<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function search(Request $request)
    {
        $search = strtolower(trim($request->input('search', $request->input('q', ''))));

        if ($search === '' || strlen($search) < 2) {
            return response()->json([
                'status' => true,
                'data' => [],
            ]);
        }

        $products = Product::query()
            ->where('status', 1)
            ->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw("LOWER(COALESCE(en_title_translation, '')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(COALESCE(ur_title_translation, '')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(COALESCE(sku, '')) LIKE ?", ["%{$search}%"])
                    ->orWhereHas('brand', function ($brandQuery) use ($search) {
                        $brandQuery->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw("LOWER(COALESCE(en_name_translation, '')) LIKE ?", ["%{$search}%"])
                            ->orWhereRaw("LOWER(COALESCE(ur_name_translation, '')) LIKE ?", ["%{$search}%"]);
                    });
            });

        if (is_numeric($search)) {
            $products->orWhere(function ($query) use ($search) {
                $query->where('status', 1)
                    ->where(function ($priceQuery) use ($search) {
                        $priceQuery->where('price', $search)
                            ->orWhere('compare_price', $search);
                    });
            });
        }

        return response()->json([
            'status' => true,
            'data' => $products
                ->with(['product_images', 'brand'])
                ->withCount('product_ratings')
                ->withSum('product_ratings', 'rating')
                ->limit(10)
                ->get(),
        ]);
    }
}