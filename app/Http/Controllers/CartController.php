<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 共用方法：当前 Cart 的查询
    |--------------------------------------------------------------------------
    */

    protected function currentCartQuery()
    {
        if (auth()->check()) {
            // 已登录：用 user_id
            return Cart::where('user_id', auth()->id());
        }

        // 游客：用 session_id
        return Cart::where('session_id', session()->getId());
    }

    protected function getOrCreateCart(): Cart
    {
        if (auth()->check()) {
            return Cart::firstOrCreate([
                'user_id' => auth()->id(),
            ]);
        }

        return Cart::firstOrCreate([
            'session_id' => session()->getId(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Cart 页面
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $cart = $this->currentCartQuery()
            ->with('items.product')
            ->first();

        $items = $cart?->items ?? collect();

        $subtotal = $items->sum(fn($item) => $item->unit_price * $item->qty);

        return view('cart.index', [
            'items'    => $items,
            'subtotal' => $subtotal,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | 加入购物车
    |--------------------------------------------------------------------------
    */

    public function add(Request $request, Product $product)
    {
        $cart = $this->getOrCreateCart();

        $qty = max(1, (int) $request->input('quantity', 1));

        $variantId    = null;
        $variantLabel = null;
        $customAmount = null;
        $unitPrice    = $product->price;

        // Open Amount product
        if ($product->is_open_amount) {
            $request->validate([
                'custom_amount' => ['required', 'numeric'],
            ]);

            $customAmount = (float) $request->input('custom_amount');

            $minAmount = (float) ($product->min_amount ?? 0);
            $maxAmount = (float) ($product->max_amount ?? 0);
            $stepAmount = (float) ($product->amount_step ?? 1);

            if ($customAmount < $minAmount) {
                return back()->with('error', 'The amount cannot be lower than RM ' . number_format($minAmount, 2) . '.');
            }

            if ($customAmount > $maxAmount) {
                return back()->with('error', 'The amount cannot be higher than RM ' . number_format($maxAmount, 2) . '.');
            }

            if ($stepAmount > 0) {
                $offset = round(($customAmount - $minAmount) / $stepAmount, 8);
                if (abs($offset - round($offset)) > 0.0000001) {
                    return back()->with('error', 'The amount must follow the allowed increment of RM ' . number_format($stepAmount, 2) . '.');
                }
            }

            $unitPrice = $customAmount;
        }
        // Variant product
        elseif ($product->has_variants) {
            $variantId = $request->input('variant_id');

            if (!$variantId) {
                return back()->with('error', 'Please select a variant before adding to cart.');
            }

            $variant = $product->variants()->where('id', $variantId)->firstOrFail();
            $unitPrice = $variant->price;

            $label = explode('/', $variant->options['label'] ?? '');
            $value = explode('/', $variant->options['value'] ?? '');

            $parts = [];
            foreach ($label as $i => $name) {
                $name = trim($name);
                $val  = trim($value[$i] ?? '');
                if ($name !== '' && $val !== '') {
                    $parts[] = "{$name}: {$val}";
                }
            }

            $variantLabel = implode(' & ', $parts);
        }

        if (is_null($unitPrice)) {
            return back()->with('error', 'This product or variant does not have a price set.');
        }

        // ==============================
        // Cart 不能混合 Digital / Physical
        // ==============================
        $isAddingDigital = (bool) $product->is_digital;

        $cartHasDigital = $cart->items()
            ->whereHas('product', function ($q) {
                $q->where('is_digital', true);
            })
            ->exists();

        $cartHasPhysical = $cart->items()
            ->whereHas('product', function ($q) {
                $q->where('is_digital', false);
            })
            ->exists();

        if ($cartHasDigital && !$isAddingDigital) {
            return back()->with(
                'error',
                'Your cart contains digital products. Please checkout or clear your cart before adding physical items.'
            );
        }

        if ($cartHasPhysical && $isAddingDigital) {
            return back()->with(
                'error',
                'Your cart contains physical products. Please checkout or clear your cart before adding digital items.'
            );
        }

        // 同 product + variant + amount 合并数量
        $query = $cart->items()->where('product_id', $product->id);

        if ($variantId) {
            $query->where('product_variant_id', $variantId);
        } else {
            $query->whereNull('product_variant_id');
        }

        if ($product->is_open_amount) {
            $query->where('unit_price', $unitPrice);
        }

        $item = $query->first();

        if ($item) {
            $item->qty += $qty;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id'         => $product->id,
                'product_variant_id' => $variantId,
                'qty'                => $qty,
                'unit_price'         => $unitPrice,
                'variant_label'      => $variantLabel ?? ($product->is_open_amount ? 'Amount: RM ' . number_format($unitPrice, 2) : null),
            ]);
        }

        return back()->with('cart_added', 'Added to cart');
    }

    /*
    |--------------------------------------------------------------------------
    | 更新数量
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, CartItem $item)
    {
        // 确保是当前用户/当前 session 的 cart item（简单校验）
        $currentCart = $this->currentCartQuery()->first();
        if (!$currentCart || $item->cart_id !== $currentCart->id) {
            abort(403);
        }

        $action = $request->input('action');

        if ($action === 'increase') {
            $item->qty++;
        } elseif ($action === 'decrease') {
            if ($item->qty > 1) {
                $item->qty--;
            } else {
                // 数量减到 0 直接删掉
                $item->delete();

                return redirect()->route('cart.index');
            }
        }

        $item->save();

        return redirect()->route('cart.index');
    }

    /*
    |--------------------------------------------------------------------------
    | 移除项目
    |--------------------------------------------------------------------------
    */

    public function remove(CartItem $item)
    {
        $currentCart = $this->currentCartQuery()->first();
        if (!$currentCart || $item->cart_id !== $currentCart->id) {
            abort(403);
        }

        $cart = $item->cart;

        $item->delete();

        if ($cart && !$cart->items()->exists()) {
            $cart->delete();
        }

        return redirect()->route('cart.index')
            ->with('success', 'Item removed.');
    }

    /*
    |--------------------------------------------------------------------------
    | 购物车数量（给 navbar 用）
    |--------------------------------------------------------------------------
    */

    public function count(): JsonResponse
    {
        $cart = $this->currentCartQuery()
            ->withCount('items')
            ->first();

        $count = $cart->items_count ?? 0;

        return response()->json([
            'count' => $count,
        ]);
    }
}
