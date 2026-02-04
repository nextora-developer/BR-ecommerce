<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{

    public function index(Request $request)
    {
        $q = Order::query()
            ->with('user'); // ✅ avoid N+1 in blade ($o->user)

        // Status
        if ($request->filled('status')) {
            $q->where('status', $request->string('status')->toString());
        }

        // Keyword (order/customer + related user)
        if ($request->filled('keyword')) {
            $keyword = trim($request->string('keyword')->toString());

            $q->where(function ($qq) use ($keyword) {
                $qq->where('order_no', 'like', "%{$keyword}%")
                    ->orWhere('customer_name', 'like', "%{$keyword}%")
                    ->orWhere('customer_phone', 'like', "%{$keyword}%")
                    ->orWhere('customer_email', 'like', "%{$keyword}%")
                    ->orWhereHas('user', function ($uq) use ($keyword) {
                        $uq->where('email', 'like', "%{$keyword}%")
                            ->orWhere('name', 'like', "%{$keyword}%");

                        // 如果 users table 有 phone 才加（没有就删掉这段）
                        $uq->orWhere('phone', 'like', "%{$keyword}%");
                    });
            });
        }

        // Date range
        if ($request->filled('from')) {
            $from = $request->date('from'); // Carbon
            $q->whereDate('created_at', '>=', $from);
        }

        if ($request->filled('to')) {
            $to = $request->date('to');
            $q->whereDate('created_at', '<=', $to);
        }

        $orders = $q->latest()->paginate(10)->withQueryString();

        $statuses = ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled', 'failed'];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }


    public function show(Order $order)
    {
        $order->load(['items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $statuses = ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled', 'failed'];

        $oldStatus = $order->status;

        // 先 load items 来判断是否 digital
        $order->loadMissing('items');
        $isDigitalOrder = $order->items->contains(fn($it) => !empty($it->digital_payload));

        // Base rules
        $rules = [
            'status'     => ['required', Rule::in($statuses)],
            'shipped_at' => ['nullable', 'date'],

            // Digital fields (A: textarea one-per-line)
            'pin_codes'          => ['nullable', 'string'], // completed 才强制（下面用 after）
            'fulfillment_note'   => ['nullable', 'string', 'max:2000'],
            'digital_fulfilled_at' => ['nullable', 'date'],
        ];

        // Physical shipping rules: 只有 physical 才 require shipping
        if (!$isDigitalOrder) {
            $rules['shipping_courier'] = ['required_if:status,shipped,completed', 'nullable', 'string', 'max:100'];
            $rules['tracking_number']  = ['required_if:status,shipped,completed', 'nullable', 'string', 'max:120'];
        } else {
            // Digital order：不要强制 shipping
            $rules['shipping_courier'] = ['nullable', 'string', 'max:100'];
            $rules['tracking_number']  = ['nullable', 'string', 'max:120'];
        }

        $validated = $request->validate($rules);

        // ✅ Digital: completed 时必须至少 1 个 PIN
        if ($isDigitalOrder && ($validated['status'] ?? null) === 'completed') {
            $raw = (string) ($validated['pin_codes'] ?? '');
            $pins = collect(preg_split("/\r\n|\n|\r/", $raw))
                ->map(fn($s) => trim($s))
                ->filter()
                ->values()
                ->all();

            if (count($pins) === 0) {
                return back()
                    ->withErrors(['pin_codes' => 'PIN Code is required for digital orders (one per line).'])
                    ->withInput();
            }
        }

        $data = [
            'status' => $validated['status'],
        ];

        // ✅ Physical: shipped/completed 保存 shipping
        if (!$isDigitalOrder && in_array($validated['status'], ['shipped', 'completed'], true)) {
            $data['shipping_courier'] = $validated['shipping_courier'] ?? $order->shipping_courier;
            $data['tracking_number']  = $validated['tracking_number'] ?? $order->tracking_number;
            $data['shipped_at']        = $validated['shipped_at'] ?? ($order->shipped_at ?? now());
        }

        // ✅ Digital: 保存 PIN + note + fulfilled_at
        if ($isDigitalOrder) {
            $raw = (string) ($validated['pin_codes'] ?? '');
            $pins = collect(preg_split("/\r\n|\n|\r/", $raw))
                ->map(fn($s) => trim($s))
                ->filter()
                ->values()
                ->all();

            // 有填才更新（避免 admin 不小心清空）
            if (!empty($raw)) {
                $data['pin_codes'] = $pins;
            }

            if ($request->has('fulfillment_note')) {
                $data['fulfillment_note'] = $validated['fulfillment_note'] ?? null;
            }

            // ✅ Digital: auto set fulfilled_at when completed
            if ($isDigitalOrder && $validated['status'] === 'completed') {
                $data['digital_fulfilled_at'] =
                    $validated['digital_fulfilled_at']
                    ?? ($order->digital_fulfilled_at ?? now());
            }
        }

        $order->update($data);
        $order->refresh();

        $newStatus = $order->status;

        if ($oldStatus !== $newStatus && $order->customer_email) {
            Log::info('Order status update mail triggered', [
                'order_no'   => $order->order_no,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'email'      => $order->customer_email,
            ]);

            try {
                Mail::to($order->customer_email)
                    ->send(new OrderStatusUpdatedMail($order, $oldStatus, $newStatus));

                Log::info('Order status email sent successfully', [
                    'order_no' => $order->order_no,
                    'to'       => $order->customer_email,
                ]);
            } catch (\Throwable $e) {
                Log::error('Order status email FAILED', [
                    'order_no' => $order->order_no,
                    'to'       => $order->customer_email,
                    'error'    => $e->getMessage(),
                ]);
            }
        }

        return back()->with('success', 'Order status updated.');
    }
}
