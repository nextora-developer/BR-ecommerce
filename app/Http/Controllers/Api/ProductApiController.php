<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    // List (给 Shop 用)
    public function index(Request $request)
    {
        $items = Product::query()
            ->where('is_active', true)
            ->select('id', 'name', 'slug', 'price', 'stock', 'is_digital', 'has_variants', 'image')
            ->latest()
            ->limit(30)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'price' => $p->price, // 可能是 "11.00" (DECIMAL) 没关系，Flutter tryParse 处理
                    'stock' => $p->stock,
                    'is_digital' => (bool) $p->is_digital,
                    'has_variants' => (bool) $p->has_variants,
                    'image' => $this->assetUrl($p->image),
                ];
            });

        return response()->json(['data' => $items]);
    }

    // Detail (给 Product Detail 用)
    public function show(string $slug)
    {
        $p = Product::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->with([
                'category:id,name,slug',
                'images:id,product_id,path,is_primary,sort_order',
                'variants:id,product_id,sku,options,price,stock,image,is_active',
                'options:id,product_id,name,label,sort_order',
                'options.values:id,product_option_id,value,sort_order',
            ])
            ->firstOrFail();

        $data = [
            'id' => $p->id,
            'name' => $p->name,
            'slug' => $p->slug,
            'short_description' => $p->short_description,
            'description' => $p->description,
            'highlights' => $p->highlights ?? [],
            'specs' => $p->specs ?? [],

            'price' => $p->price,
            'stock' => $p->stock,

            'is_digital' => (bool) $p->is_digital,
            'digital_fields' => $p->digital_fields ?? [],
            'has_variants' => (bool) $p->has_variants,

            'category' => $p->category ? [
                'id' => $p->category->id,
                'name' => $p->category->name,
                'slug' => $p->category->slug,
            ] : null,

            // Product images
            'images' => $p->images
                ->sortBy('sort_order')
                ->values()
                ->map(fn($img) => [
                    'path' => $this->assetUrl($img->path),
                    'is_primary' => (bool) $img->is_primary,
                    'sort_order' => (int) $img->sort_order,
                ]),

            // Variants
            'variants' => $p->variants
                ->where('is_active', true)
                ->values()
                ->map(fn($v) => [
                    'id' => $v->id,
                    'sku' => $v->sku,
                    'options' => $v->options ?? [],
                    'label' => $v->label, // accessor
                    'value' => $v->value, // accessor
                    'price' => $v->price,
                    'stock' => $v->stock,
                    'image' => $this->assetUrl($v->image),
                ]),

            // Options / option values (for UI selectors)
            'options' => $p->options
                ->sortBy('sort_order')
                ->values()
                ->map(fn($opt) => [
                    'id' => $opt->id,
                    'name' => $opt->name,
                    'label' => $opt->label,
                    'values' => $opt->values
                        ->sortBy('sort_order')
                        ->values()
                        ->map(fn($val) => [
                            'id' => $val->id,
                            'value' => $val->value,
                        ]),
                ]),
        ];

        // fallback 主图：优先 primary image
        $primary = $p->images->firstWhere('is_primary', true);
        $data['primary_image'] = $this->assetUrl($primary?->path ?? $p->image);

        return response()->json(['data' => $data]);
    }

    private function assetUrl(?string $path): ?string
    {
        if (!$path) return null;

        // 已经是完整 URL 就原样
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // 允许你存 "/storage/xxx" 或 "storage/xxx" 或 "products/xxx"
        if (str_starts_with($path, '/')) return url($path);
        return url('/' . $path);
    }
}
