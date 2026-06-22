<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use App\Services\DiscountService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    protected $discountService;
    protected $productService;

    public function __construct(
        DiscountService $discountService,
        ProductService $productService
    ) {
        $this->discountService = $discountService;
        $this->productService = $productService;
    }

    public function search(Request $request)
    {
        $wishlistitems = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->with('product')->get()->keyBy('product_id')
            : collect();

        $discounts = $this->discountService->getActiveDiscounts();

        $latestproduct = $this->discountService->applyDiscount(
            $this->productService->latestProducts(limit: 12),
            $discounts
        );

        $data['wishlist'] = $wishlistitems;
        $data['latestproducts'] = $latestproduct;

        return Inertia::render('Front/Search', $data);
    }

    public function searchProducts(Request $request)
    {
        $keyword = trim($request->input('q'));

        if (!$keyword || strlen($keyword) < 2) {
            return response()->json([]);
        }

        $discounts = $this->discountService->getActiveDiscounts();

        $searchedproduct = $this->discountService->applyDiscount(
            $this->productService->searchProducts($keyword),
            $discounts
        );

        return response()->json($searchedproduct);
    }

    public function searchProductsByImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            ]);

            if (!extension_loaded('gd')) {
                return response()->json([
                    'status' => false,
                    'message' => 'PHP GD extension is not enabled. Please enable extension=gd in php.ini.',
                    'data' => [],
                ]);
            }

            $uploadedImagePath = $request->file('image')->getRealPath();

            $queryHash = $this->averageHash($uploadedImagePath);

            if (!$queryHash) {
                return response()->json([
                    'status' => false,
                    'message' => 'Could not read uploaded image. Please use JPG, PNG, or WEBP.',
                    'data' => [],
                ]);
            }

            $products = Product::query()
                ->where('status', 1)
                ->with('product_images')
                ->get();

            $matches = [];

            foreach ($products as $product) {
                $bestDistance = null;

                foreach ($product->product_images as $productImage) {
                    if (empty($productImage->image)) {
                        continue;
                    }

                    $imagePath = public_path('upload/products/' . $productImage->image);

                    if (!File::exists($imagePath)) {
                        continue;
                    }

                    $productHash = $this->averageHash($imagePath);

                    if (!$productHash) {
                        continue;
                    }

                    $distance = $this->hammingDistance($queryHash, $productHash);

                    if ($bestDistance === null || $distance < $bestDistance) {
                        $bestDistance = $distance;
                    }
                }

                if ($bestDistance !== null) {
                    $product->image_match_score = round(100 - (($bestDistance / 64) * 100), 2);

                    if (!isset($product->actual_price)) {
                        $product->actual_price = $product->price ?? 0;
                    }

                    if (!isset($product->discounted_price)) {
                        $product->discounted_price = $product->price ?? 0;
                    }

                    if (!isset($product->discount_value)) {
                        $product->discount_value = 0;
                    }

                    if (!isset($product->avg_rating)) {
                        $product->avg_rating = 0;
                    }

                    $matches[] = [
                        'product' => $product,
                        'distance' => $bestDistance,
                    ];
                }
            }

            $matchedProducts = collect($matches)
                ->sortBy('distance')
                ->take(12)
                ->pluck('product')
                ->values();

            return response()->json([
                'status' => true,
                'message' => 'Image search completed.',
                'data' => $matchedProducts,
            ]);

        } catch (\Throwable $exception) {
            Log::error('Image search error', [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);

            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    private function averageHash(string $imagePath): ?string
    {
        $info = @getimagesize($imagePath);

        if (!$info || empty($info['mime'])) {
            return null;
        }

        $source = null;

        if ($info['mime'] === 'image/jpeg') {
            $source = @imagecreatefromjpeg($imagePath);
        }

        if ($info['mime'] === 'image/png') {
            $source = @imagecreatefrompng($imagePath);
        }

        if ($info['mime'] === 'image/webp' && function_exists('imagecreatefromwebp')) {
            $source = @imagecreatefromwebp($imagePath);
        }

        if (!$source) {
            return null;
        }

        $smallImage = imagecreatetruecolor(8, 8);

        imagecopyresampled(
            $smallImage,
            $source,
            0,
            0,
            0,
            0,
            8,
            8,
            imagesx($source),
            imagesy($source)
        );

        $grayValues = [];
        $totalGray = 0;

        for ($y = 0; $y < 8; $y++) {
            for ($x = 0; $x < 8; $x++) {
                $rgb = imagecolorat($smallImage, $x, $y);

                $red = ($rgb >> 16) & 255;
                $green = ($rgb >> 8) & 255;
                $blue = $rgb & 255;

                $gray = (int) (($red + $green + $blue) / 3);

                $grayValues[] = $gray;
                $totalGray += $gray;
            }
        }

        imagedestroy($source);
        imagedestroy($smallImage);

        $averageGray = $totalGray / 64;

        $hash = '';

        foreach ($grayValues as $gray) {
            $hash .= $gray >= $averageGray ? '1' : '0';
        }

        return $hash;
    }

    private function hammingDistance(string $hashA, string $hashB): int
    {
        $distance = 0;

        for ($i = 0; $i < 64; $i++) {
            if (($hashA[$i] ?? null) !== ($hashB[$i] ?? null)) {
                $distance++;
            }
        }

        return $distance;
    }
}