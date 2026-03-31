<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::query()->with('category');

        if ($request->filled('keyword')) {
            $kw = $request->string('keyword');
            $q->where(function ($qq) use ($kw) {
                $qq->where('name', 'like', "%{$kw}%")
                    ->orWhere('slug', 'like', "%{$kw}%");
            });
        }

        if ($request->filled('status')) {
            $q->where('is_active', $request->string('status') === 'active');
        }

        if ($request->filled('category_id')) {
            $q->where('category_id', $request->integer('category_id'));
        }

        $products = $q->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::whereNotNull('parent_id')
            ->with('parent')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.products.form', [
            'product'    => new Product(),
            'categories' => $categories,
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'reward_points' => ['nullable', 'integer', 'min:0'],

            'has_variants' => ['nullable', 'boolean'],

            'is_open_amount' => ['nullable', 'boolean'],
            'min_amount' => ['nullable', 'numeric', 'min:0'],
            'max_amount' => ['nullable', 'numeric', 'gte:min_amount'],
            'amount_step' => ['nullable', 'numeric', 'min:0.01'],

            // 没有 variants 时必须填 price；有 variants 时可以不用填 price
            'price'  => ['nullable', 'numeric', 'min:0', 'required_without:variants'],
            'stock'  => ['nullable', 'integer', 'min:0'],

            // variants 是一个 array
            'variants'              => ['nullable', 'array', 'required_without:price'],
            'variants.*.sku'        => ['nullable', 'string', 'max:100'],
            'variants.*.label'      => ['nullable', 'string', 'max:255'],
            'variants.*.value'      => ['nullable', 'string', 'max:255'],
            'variants.*.price'      => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock'      => ['nullable', 'integer', 'min:0'],

            // ⭐ Highlights dropdown (最多4个)
            'highlights'   => ['nullable', 'array', 'max:4'],
            'highlights.*' => ['nullable', 'string', 'max:50'],

            // ⭐ Shopee-style 规格（Additional Info）
            'specs'              => ['nullable', 'array'],
            'specs.*.name'       => ['nullable', 'string', 'max:255'],
            'specs.*.value'      => ['nullable', 'string', 'max:1000'],

            // 多图上传
            'images'     => ['nullable', 'array'],
            'images.*'   => ['nullable', 'image', 'max:2048'],

            // 旧的单图字段（form 不用的话也没关系，保留兼容）
            'image'     => ['nullable', 'image', 'max:2048'],

            'digital_fields_builder' => ['nullable', 'array'],
            'digital_fields_builder.*.key' => ['nullable', 'string', 'max:50'],
            'digital_fields_builder.*.label' => ['nullable', 'string', 'max:80'],
            'digital_fields_builder.*.type' => ['nullable', 'in:text,number,select'],
            'digital_fields_builder.*.required' => ['nullable'], // checkbox
            'digital_fields_builder.*.max' => ['nullable', 'integer', 'min:1', 'max:255'],
            'digital_fields_builder.*.hint' => ['nullable', 'string', 'max:120'],
            'digital_fields_builder.*.options' => ['nullable', 'array'],
            'digital_fields_builder.*.options.*' => ['nullable', 'string', 'max:50'],

            'digital_fields' => ['nullable', 'string'],

            'is_active' => ['nullable', 'boolean'],
            'is_digital' => ['nullable', 'boolean'],
        ]);

        // slug auto
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['reward_points'] = (int) ($data['reward_points'] ?? 0);

        // checkbox normalize
        $data['is_active']   = $request->boolean('is_active');
        $data['has_variants'] = $request->boolean('has_variants');
        $data['is_digital']   = $request->boolean('is_digital');
        $data['is_open_amount'] = $request->boolean('is_open_amount');

        // pricing mode guard
        if ($data['is_open_amount'] && $data['has_variants']) {
            return back()
                ->withErrors(['is_open_amount' => 'Open Amount product cannot use variants at the same time.'])
                ->withInput();
        }

        if ($data['is_open_amount']) {
            if (!$request->filled('min_amount')) {
                return back()->withErrors(['min_amount' => 'Min amount is required.'])->withInput();
            }

            if (!$request->filled('max_amount')) {
                return back()->withErrors(['max_amount' => 'Max amount is required.'])->withInput();
            }

            if (!$request->filled('amount_step')) {
                return back()->withErrors(['amount_step' => 'Amount step is required.'])->withInput();
            }

            $data['price'] = null;
            $data['has_variants'] = false;
        } elseif ($data['has_variants']) {
            $hasAtLeastOneVariant = collect($request->input('variants', []))->contains(function ($variant) {
                return filled($variant['label'] ?? null)
                    || filled($variant['value'] ?? null)
                    || filled($variant['price'] ?? null)
                    || filled($variant['stock'] ?? null)
                    || filled($variant['sku'] ?? null);
            });

            if (!$hasAtLeastOneVariant) {
                return back()->withErrors(['variants' => 'Please add at least one variant.'])->withInput();
            }

            $data['price'] = null;
        } else {
            if (!$request->filled('price')) {
                return back()->withErrors(['price' => 'Price is required for simple product.'])->withInput();
            }
        }

        // =========================
        // Digital fields: Builder first, JSON fallback
        // =========================
        $digitalFields = null;

        if ($data['is_digital']) {

            // 1) Builder array 优先
            $builder = $request->input('digital_fields_builder', []);

            if (is_array($builder) && !empty($builder)) {
                $digitalFields = collect($builder)
                    ->filter(fn($f) => filled($f['key'] ?? null) && filled($f['label'] ?? null))
                    ->map(function ($f) {
                        $type = $f['type'] ?? 'text';

                        $field = [
                            'key'      => (string) $f['key'],
                            'label'    => (string) $f['label'],
                            'required' => !empty($f['required']),
                            'type'     => $type,
                            'max'      => isset($f['max']) && $f['max'] !== '' ? (int) $f['max'] : null,
                            'hint'     => filled($f['hint'] ?? null) ? (string) $f['hint'] : null,
                        ];

                        if ($type === 'select') {
                            $opts = $f['options'] ?? [];
                            if (!is_array($opts)) $opts = [];
                            $field['options'] = collect($opts)->filter(fn($v) => filled($v))->values()->all();
                        }

                        return $field;
                    })
                    ->values()
                    ->all();
            }

            // 2) 如果 builder 没填，才走 advanced JSON textarea（兼容你之前做法）
            if ($digitalFields === null) {
                $raw = trim((string) $request->input('digital_fields', ''));
                if ($raw !== '') {
                    $decoded = json_decode($raw, true);
                    if (!is_array($decoded)) {
                        return back()->withErrors(['digital_fields' => 'Invalid JSON format. Must be a JSON array.'])->withInput();
                    }
                    $digitalFields = $decoded;
                } else {
                    $digitalFields = [];
                }
            }

            // 3) 强校验 key 格式（避免 checkout 表单 name 爆掉）
            foreach ($digitalFields as $idx => $f) {
                if (empty($f['key']) || empty($f['label'])) {
                    return back()->withErrors(['digital_fields' => 'Field #' . ($idx + 1) . ' must have key and label.'])->withInput();
                }
                if (!preg_match('/^[a-zA-Z0-9_]+$/', (string) $f['key'])) {
                    return back()->withErrors(['digital_fields' => 'Field #' . ($idx + 1) . ' key must be alphanumeric/underscore only.'])->withInput();
                }
                if (($f['type'] ?? 'text') === 'select' && isset($f['options']) && !is_array($f['options'])) {
                    return back()->withErrors(['digital_fields' => 'Field #' . ($idx + 1) . ' options must be an array.'])->withInput();
                }
            }
        } else {
            $digitalFields = null;
        }

        $data['digital_fields'] = $digitalFields;



        // 先拿出来 variants & specs & images，剩下的是 products 表的数据
        $variantsInput = $data['variants'] ?? [];
        $specsInput    = $data['specs'] ?? [];
        $highlightsInput = $data['highlights'] ?? [];

        unset($data['variants']);
        unset($data['highlights']); // ✅ 新增

        $imagesInput = $request->file('images', []); // 这里直接从 request 拿 file

        // 如果你已经完全不用旧的 image 字段，这里可以不处理 $data['image']

        // ⭐ 处理 specs：过滤掉全空的行
        $specs = collect($specsInput)
            ->filter(function ($row) {
                return filled($row['name'] ?? null) || filled($row['value'] ?? null);
            })
            ->values()
            ->all();

        if ($data['is_open_amount']) {
            // open amount 一般不看 stock；你可以固定 0 或 null
            $data['stock'] = 0;
        } elseif ($data['has_variants']) {
            $totalStock = 0;
            foreach ($variantsInput as $v) {
                $totalStock += (int) ($v['stock'] ?? 0);
            }
            $data['stock'] = $totalStock;
        } else {
            $data['stock'] = $data['stock'] ?? 0;
        }

        // ⭐ 处理 highlights：过滤空 + 最多4个 + 去重（避免重复选）
        $highlights = collect($highlightsInput)
            ->filter(fn($v) => filled($v))
            ->unique()
            ->take(4)
            ->values()
            ->all();

        $data['highlights'] = $highlights;

        // ⭐ 把处理好的 specs 塞回 data
        $data['specs'] = $specs;


        // 先创建产品（先不处理 image 字段）
        $product = Product::create($data);

        // 再存 variants（如果有）
        if ($data['has_variants'] && !empty($variantsInput)) {
            foreach ($variantsInput as $variant) {

                // 全空就跳过
                if (
                    ($variant['sku'] ?? '')   === '' &&
                    ($variant['label'] ?? '') === '' &&
                    ($variant['value'] ?? '') === '' &&
                    ($variant['price'] ?? '') === '' &&
                    ($variant['stock'] ?? '') === ''
                ) {
                    continue;
                }

                $options = [
                    'label' => $variant['label'] ?? null,
                    'value' => $variant['value'] ?? null,
                ];

                $product->variants()->create([
                    'sku'       => $variant['sku'] ?? null,
                    'options'   => $options,  // 👈 存 JSON
                    'price'     => isset($variant['price']) && $variant['price'] !== '' ? $variant['price'] : null,
                    'stock'     => isset($variant['stock']) && $variant['stock'] !== '' ? (int) $variant['stock'] : 0,
                    'is_active' => true,
                ]);
            }
            $this->syncOptionsFromVariants($product, $variantsInput);
        } else {
            // 没有 variants 的话，确保把旧的 options 清掉（新商品一般没有旧的）
            $this->syncOptionsFromVariants($product, []);
        }

        // dd($request->allFiles(), $request->file('images'));


        // 处理多图上传：存去 product_images，并设第一张为封面
        if (!empty($imagesInput)) {
            foreach ($imagesInput as $index => $file) {
                if (!$file) {
                    continue;
                }

                $path = $file->store('products', 'public');

                $image = new ProductImage([
                    'path'       => $path,
                    'is_primary' => $index === 0,  // 第一张当封面
                    'sort_order' => $index,
                ]);

                $product->images()->save($image);

                // 如果是封面，同步到 products.image 字段
                if ($index === 0) {
                    $product->update(['image' => $path]);
                }
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created.');
    }

    private function syncOptionsFromVariants(Product $product, array $variantsInput): void
    {
        // 先从 variantsInput 里面整理出：
        // $groupValues['Color'] = ['Black', 'White']
        // $groupValues['Size']  = ['S', 'M', 'L']
        $groupValues = [];

        foreach ($variantsInput as $variant) {
            $label = $variant['label'] ?? null;
            $value = $variant['value'] ?? null;

            if (!$label || !$value) {
                continue;
            }

            // 用 / 分隔： "Color / Size" + "Black / M"
            $labels = array_map('trim', explode('/', $label));
            $values = array_map('trim', explode('/', $value));

            foreach ($labels as $index => $groupName) {
                $groupName = trim($groupName);
                $val = $values[$index] ?? null;
                $val = $val ? trim($val) : null;

                if ($groupName === '' || $val === null || $val === '') {
                    continue;
                }

                // 用 [groupName][value] 做去重
                $groupValues[$groupName][$val] = true;
            }
        }

        // 先删掉旧的 options & values
        $oldOptionIds = $product->options()->pluck('id')->all();
        if (!empty($oldOptionIds)) {
            ProductOptionValue::whereIn('product_option_id', $oldOptionIds)->delete();
            ProductOption::whereIn('id', $oldOptionIds)->delete();
        }

        if (empty($groupValues)) {
            return;
        }

        // 重建新的 options & values
        $optionSort = 0;

        foreach ($groupValues as $groupName => $values) {
            $option = $product->options()->create([
                'name'       => Str::slug($groupName), // e.g. "warna-saiz"
                'label'      => $groupName,            // e.g. "Warna" / "Saiz"
                'sort_order' => $optionSort++,
            ]);

            $valueSort = 0;

            foreach (array_keys($values) as $val) {
                $option->values()->create([
                    'value'      => $val,
                    'sort_order' => $valueSort++,
                ]);
            }
        }
    }


    public function edit(Product $product)
    {
        $product->load('variants', 'images');

        $categories = Category::whereNotNull('parent_id')
            ->with('parent')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.products.form', compact('product', 'categories'));
    }


    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'reward_points' => ['nullable', 'integer', 'min:0'],

            'has_variants' => ['nullable', 'boolean'],

            'is_open_amount' => ['nullable', 'boolean'],
            'min_amount' => ['nullable', 'numeric', 'min:0'],
            'max_amount' => ['nullable', 'numeric', 'gte:min_amount'],
            'amount_step' => ['nullable', 'numeric', 'min:0.01'],

            'price'  => ['nullable', 'numeric', 'min:0'],
            'stock'  => ['nullable', 'integer', 'min:0'],

            // variants 数组
            'variants'              => ['nullable', 'array'],
            'variants.*.sku'        => ['nullable', 'string', 'max:100'],
            'variants.*.label'      => ['nullable', 'string', 'max:255'],
            'variants.*.value'      => ['nullable', 'string', 'max:255'],
            'variants.*.price'      => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock'      => ['nullable', 'integer', 'min:0'],

            // ⭐ Highlights dropdown (最多4个)
            'highlights'   => ['nullable', 'array', 'max:4'],
            'highlights.*' => ['nullable', 'string', 'max:50'],

            // ⭐ Shopee-style 规格（Additional Info）
            'specs'              => ['nullable', 'array'],
            'specs.*.name'       => ['nullable', 'string', 'max:255'],
            'specs.*.value'      => ['nullable', 'string', 'max:1000'],

            // 多图上传
            'images'     => ['nullable', 'array'],
            'images.*'   => ['nullable', 'image', 'max:2048'],

            // 旧的 image 字段
            'image'     => ['nullable', 'image', 'max:2048'],

            'digital_fields_builder' => ['nullable', 'array'],
            'digital_fields_builder.*.key' => ['nullable', 'string', 'max:50'],
            'digital_fields_builder.*.label' => ['nullable', 'string', 'max:80'],
            'digital_fields_builder.*.type' => ['nullable', 'in:text,number,select'],
            'digital_fields_builder.*.required' => ['nullable'], // checkbox
            'digital_fields_builder.*.max' => ['nullable', 'integer', 'min:1', 'max:255'],
            'digital_fields_builder.*.hint' => ['nullable', 'string', 'max:120'],
            'digital_fields_builder.*.options' => ['nullable', 'array'],
            'digital_fields_builder.*.options.*' => ['nullable', 'string', 'max:50'],

            'digital_fields' => ['nullable', 'string'],

            'is_active' => ['nullable', 'boolean'],
            'is_digital' => ['nullable', 'boolean'],
        ]);

        // slug auto
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['reward_points'] = (int) ($data['reward_points'] ?? 0);

        // checkbox normalize
        $data['is_active']   = $request->boolean('is_active');
        $data['has_variants'] = $request->boolean('has_variants');
        $data['is_digital']   = $request->boolean('is_digital');
        $data['is_open_amount'] = $request->boolean('is_open_amount');

        // pricing mode guard
        if ($data['is_open_amount'] && $data['has_variants']) {
            return back()
                ->withErrors(['is_open_amount' => 'Open Amount product cannot use variants at the same time.'])
                ->withInput();
        }

        if ($data['is_open_amount']) {
            if (!$request->filled('min_amount')) {
                return back()->withErrors(['min_amount' => 'Min amount is required.'])->withInput();
            }

            if (!$request->filled('max_amount')) {
                return back()->withErrors(['max_amount' => 'Max amount is required.'])->withInput();
            }

            if (!$request->filled('amount_step')) {
                return back()->withErrors(['amount_step' => 'Amount step is required.'])->withInput();
            }

            $data['price'] = null;
            $data['has_variants'] = false;
        } elseif ($data['has_variants']) {
            $hasAtLeastOneVariant = collect($request->input('variants', []))->contains(function ($variant) {
                return filled($variant['label'] ?? null)
                    || filled($variant['value'] ?? null)
                    || filled($variant['price'] ?? null)
                    || filled($variant['stock'] ?? null)
                    || filled($variant['sku'] ?? null);
            });

            if (!$hasAtLeastOneVariant) {
                return back()->withErrors(['variants' => 'Please add at least one variant.'])->withInput();
            }

            $data['price'] = null;
        } else {
            if (!$request->filled('price')) {
                return back()->withErrors(['price' => 'Price is required for simple product.'])->withInput();
            }
        }

        // =========================
        // Digital fields: Builder first, JSON fallback
        // =========================
        $digitalFields = null;

        if ($data['is_digital']) {

            // 1) Builder array 优先
            $builder = $request->input('digital_fields_builder', []);

            if (is_array($builder) && !empty($builder)) {
                $digitalFields = collect($builder)
                    ->filter(fn($f) => filled($f['key'] ?? null) && filled($f['label'] ?? null))
                    ->map(function ($f) {
                        $type = $f['type'] ?? 'text';

                        $field = [
                            'key'      => (string) $f['key'],
                            'label'    => (string) $f['label'],
                            'required' => !empty($f['required']),
                            'type'     => $type,
                            'max'      => isset($f['max']) && $f['max'] !== '' ? (int) $f['max'] : null,
                            'hint'     => filled($f['hint'] ?? null) ? (string) $f['hint'] : null,
                        ];

                        if ($type === 'select') {
                            $opts = $f['options'] ?? [];
                            if (!is_array($opts)) $opts = [];
                            $field['options'] = collect($opts)->filter(fn($v) => filled($v))->values()->all();
                        }

                        return $field;
                    })
                    ->values()
                    ->all();
            }

            // 2) 如果 builder 没填，才走 advanced JSON textarea（兼容你之前做法）
            if ($digitalFields === null) {
                $raw = trim((string) $request->input('digital_fields', ''));
                if ($raw !== '') {
                    $decoded = json_decode($raw, true);
                    if (!is_array($decoded)) {
                        return back()->withErrors(['digital_fields' => 'Invalid JSON format. Must be a JSON array.'])->withInput();
                    }
                    $digitalFields = $decoded;
                } else {
                    $digitalFields = [];
                }
            }

            // 3) 强校验 key 格式（避免 checkout 表单 name 爆掉）
            foreach ($digitalFields as $idx => $f) {
                if (empty($f['key']) || empty($f['label'])) {
                    return back()->withErrors(['digital_fields' => 'Field #' . ($idx + 1) . ' must have key and label.'])->withInput();
                }
                if (!preg_match('/^[a-zA-Z0-9_]+$/', (string) $f['key'])) {
                    return back()->withErrors(['digital_fields' => 'Field #' . ($idx + 1) . ' key must be alphanumeric/underscore only.'])->withInput();
                }
                if (($f['type'] ?? 'text') === 'select' && isset($f['options']) && !is_array($f['options'])) {
                    return back()->withErrors(['digital_fields' => 'Field #' . ($idx + 1) . ' options must be an array.'])->withInput();
                }
            }
        } else {
            $digitalFields = null;
        }

        $data['digital_fields'] = $digitalFields;

        // 拆出 variants / specs，其余为 products 字段
        $variantsInput = $data['variants'] ?? [];
        $specsInput    = $data['specs'] ?? [];
        $highlightsInput = $data['highlights'] ?? [];


        unset($data['variants']);
        unset($data['highlights']); // ✅ 新增


        $imagesInput = $request->file('images', []);

        // ⭐ 处理 specs：过滤空行
        $specs = collect($specsInput)
            ->filter(
                fn($row) =>
                filled($row['name'] ?? null) || filled($row['value'] ?? null)
            )
            ->values()
            ->all();

        // 处理 stock（和 store() 一样）
        if ($data['is_open_amount']) {
            $data['stock'] = 0;
        } elseif ($data['has_variants']) {
            $totalStock = 0;
            foreach ($variantsInput as $v) {
                $totalStock += (int) ($v['stock'] ?? 0);
            }
            $data['stock'] = $totalStock;
        } else {
            $data['stock'] = $data['stock'] ?? 0;
        }

        $highlights = collect($highlightsInput)
            ->filter(fn($v) => filled($v))
            ->unique()
            ->take(4)
            ->values()
            ->all();

        $data['highlights'] = $highlights;


        // ⭐ 保存 specs
        $data['specs'] = $specs;

        // 先更新 product 本体（不动 image 字段，后面根据新图片再 update）
        $product->update($data);

        // 先把旧 variants 清掉，重新建
        $product->variants()->delete();

        if ($data['has_variants'] && !empty($variantsInput)) {

            foreach ($variantsInput as $variant) {
                // 完全空的行就跳过
                if (
                    ($variant['sku'] ?? '')   === '' &&
                    ($variant['label'] ?? '') === '' &&
                    ($variant['value'] ?? '') === '' &&
                    ($variant['price'] ?? '') === '' &&
                    ($variant['stock'] ?? '') === ''
                ) {
                    continue;
                }

                $options = [
                    'label' => $variant['label'] ?? null,
                    'value' => $variant['value'] ?? null,
                ];

                $product->variants()->create([
                    'sku'       => $variant['sku'] ?? null,
                    'options'   => $options, // 👈 把 label/value 放进 JSON
                    'price'     => isset($variant['price']) && $variant['price'] !== '' ? $variant['price'] : null,
                    'stock'     => isset($variant['stock']) && $variant['stock'] !== '' ? (int) $variant['stock'] : 0,
                    'is_active' => true,
                ]);
            }

            // 同步 product_options / product_option_values
            $this->syncOptionsFromVariants($product, $variantsInput);
        } else {
            // 没有 variants，清空旧 options
            $this->syncOptionsFromVariants($product, []);
        }

        // =========================
        // 图片处理（支持：删除旧图 + 拖动排序 + 新增图片）
        // =========================
        $imagesInput   = $request->file('images', []);
        $finalOrder    = $request->input('final_order', []);        // ["e:12","n:abc",...]
        $deleteIds     = collect($request->input('delete_image_ids', []))
            ->filter(fn($v) => is_numeric($v))
            ->map(fn($v) => (int)$v)
            ->values();

        // ---- A) 兼容旧逻辑：如果你还没接前端 final_order/delete，而且有新图，就整组替换（原来的行为）----
        $useLegacyReplaceAll = empty($finalOrder) && $deleteIds->isEmpty() && !empty($imagesInput);

        if ($useLegacyReplaceAll) {
            // 1) 先删旧图片文件 + DB 记录
            foreach ($product->images as $img) {
                if ($img->path) {
                    Storage::disk('public')->delete($img->path);
                }
            }
            $product->images()->delete();

            // products.image 一起删
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
                $product->image = null;
                $product->save();
            }

            // 2) 再存新的图片
            $primaryPath = null;
            foreach ($imagesInput as $index => $file) {
                if (!$file) continue;

                $path = $file->store('products', 'public');

                $product->images()->create([
                    'path'       => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);

                if ($index === 0) $primaryPath = $path;
            }

            if ($primaryPath) {
                $product->update(['image' => $primaryPath]);
            }
        } else {
            // ---- B) 新逻辑：删除 / 排序 / 新增（可混排）----

            // 1) 删除旧图（DB + storage）
            if ($deleteIds->isNotEmpty()) {
                $imgs = $product->images()->whereIn('id', $deleteIds)->get();
                foreach ($imgs as $img) {
                    if ($img->path) {
                        Storage::disk('public')->delete($img->path);
                    }
                    $img->delete();
                }
            }

            // 2) 先算总数上限 10（旧-删 + 新）
            $remainingExistingCount = $product->images()->count();
            $incomingCount = is_array($imagesInput) ? count($imagesInput) : 0;

            if (($remainingExistingCount + $incomingCount) > 10) {
                return back()
                    ->withErrors(['images' => 'Max 10 images total (existing + new).'])
                    ->withInput();
            }

            // 3) 上传新图（先 create 出来，sort_order 等下用 final_order 统一写）
            //    ⚠️ 注意：前端必须保证 input.files 的顺序已经按 “final_order 里的 new 顺序” 排好
            $justCreated = collect();
            if (!empty($imagesInput)) {
                foreach ($imagesInput as $file) {
                    if (!$file) continue;

                    $path = $file->store('products', 'public');

                    $img = $product->images()->create([
                        'path'       => $path,
                        'is_primary' => false,
                        'sort_order' => 9999, // 临时
                    ]);

                    $justCreated->push($img);
                }
            }

            // 4) 如果没有 final_order（例如你只上传了新图但没做拖动），就默认：旧图原顺序 + 新图追加
            $final = collect($finalOrder)
                ->filter(fn($v) => is_string($v) && (str_starts_with($v, 'e:') || str_starts_with($v, 'n:')))
                ->values();

            if ($final->isEmpty()) {
                $existingIds = $product->images()
                    ->whereNotIn('id', $justCreated->pluck('id')->all())
                    ->orderBy('sort_order')
                    ->pluck('id')
                    ->map(fn($id) => "e:$id");

                $newTokens = $justCreated->map(fn() => 'n:x'); // 占位 token
                $final = $existingIds->concat($newTokens)->values();
            }

            // 5) 按 final_order 统一写 sort_order + is_primary
            $existingMap = $product->images()->get()->keyBy('id');
            $consumeNewIndex = 0;

            // 先全部取消 primary
            $product->images()->update(['is_primary' => false]);

            foreach ($final as $i => $token) {
                if (str_starts_with($token, 'e:')) {
                    $id = (int) substr($token, 2);
                    if ($existingMap->has($id)) {
                        $existingMap[$id]->update(['sort_order' => $i]);
                    }
                } else {
                    // n:key -> 我们按“创建顺序”消费（因为 input.files 已经被前端按 new 的最终顺序排好了）
                    if ($consumeNewIndex < $justCreated->count()) {
                        $justCreated[$consumeNewIndex]->update(['sort_order' => $i]);
                        $consumeNewIndex++;
                    }
                }
            }

            // 6) 把 sort_order 最小的设为 primary，并同步到 products.image
            $first = $product->images()->orderBy('sort_order')->first();
            if ($first) {
                $first->update(['is_primary' => true]);
                $product->update(['image' => $first->path]);
            } else {
                // 如果全部删光
                if ($product->image) {
                    // 这里不强制删旧文件（因为可能已经被删），但你要严谨也可以 exists 再 delete
                    $product->update(['image' => null]);
                }
            }
        }



        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated.');
    }


    public function destroy(Product $product)
    {
        // 顺便把图片文件删掉（避免 storage 爆掉）
        foreach ($product->images as $img) {
            if ($img->path) {
                Storage::disk('public')->delete($img->path);
            }
        }

        // 如果 products.image 也有存封面路径，可以一起删（重复删也不会出错）
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 删掉 images 记录（如果没有在 migration 里做 onDelete('cascade')）
        $product->images()->delete();

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted.');
    }

    public function toggle(Product $product)
    {
        $product->update([
            'is_active' => ! $product->is_active,
        ]);

        return back()->with('success', 'Product status updated.');
    }

    public function duplicate(Product $product)
    {
        DB::transaction(function () use ($product) {

            // 1️⃣ 复制主产品
            $new = $product->replicate([
                'slug',
                'created_at',
                'updated_at',
            ]);

            $new->name = $product->name . ' (Copy)';
            $new->slug = Str::slug($new->name) . '-' . Str::random(4);
            $new->is_active = false; // 复制后默认隐藏更安全
            $new->save();

            // 2️⃣ 复制 variants（如果有）
            if ($product->variants()->exists()) {
                foreach ($product->variants as $variant) {
                    $new->variants()->create(
                        $variant->replicate([
                            'id',
                            'product_id',
                            'created_at',
                            'updated_at',
                        ])->toArray()
                    );
                }
            }
        });

        return back()->with('success', 'Product duplicated successfully');
    }
}
