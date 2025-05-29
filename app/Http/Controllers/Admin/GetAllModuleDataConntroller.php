<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Category;
use App\Models\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetAllModuleDataConntroller extends Controller
{
    public function loadCategories(Request $request)
    {
        $categories = Category::select('id', 'name_english', 'name_bangla', 'parent_id')
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'success',
            'categories' => $categories,
        ]);
    }

    public function loadSizes(Request $request)
    {
        $sizes = Size::select('id', 'name', 'name_bangla', 'size')
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'success',
            'sizes' => $sizes,
        ]);
    }
    public function loadColor(Request $request)
    {
        $colors = Color::select('id', 'name_english', 'code')
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'success',
            'colors' => $colors,
        ]);
    }
    public function loadBrand(Request $request)
    {
        $brands = Brand::select('id', 'name_english', 'logo')
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'success',
            'brands' => $brands,
        ]);
    }



    public function loadCategoory()
    {
        $categories = Category::latest()->paginate(10);

        // if ($request->expectsJson()) {
        return response()->json([
            'message' => 'success',
            'categories' => $categories,
        ]);
    }
    public function loadUnit()
    {
        $units = Uom::latest()->first();

        return response()->json([
            'message' => 'success',
            'units' => $units,
        ]);
    }

    public function loadColor12()
    {
        $categoriesData = [];
        DB::table('categories')
            ->where('status', true)
            ->chunkById(100, function ($categories) use (&$categoriesData) {
                foreach ($categories as $category) {
                    // Extract category ID and name
                    $categoryId = $category->id;
                    $categoryName = $category->name;
                    $categoriesData[] = [
                        'id' => $categoryId,
                        'name' => $categoryName,
                    ];
                }
            });

        // Encode $categoriesData array into JSON format and return it
        return response()->json($categoriesData);
    }










    // public function loadSubcategories(Request $request, $categoryId)
    // {
    //     $subcategories = Category::where('parent_id', $categoryId)->get();

    //     return response()->json([
    //         'subcategories' => $subcategories,
    //     ]);
    // }

    // public function loadChildrenCategories(Request $request, $subcategoryId)
    // {
    //     $childcategories = Category::where('parent_id', $subcategoryId)->get();

    //     return response()->json([
    //         'childcategories' => $childcategories,
    //     ]);
    // }








    public function loadChildrenCategories(Request $request, $parentId)
    {
        $subcategories = Category::where('parent_id', $parentId)->get();
        return Category::collection($subcategories);
    }


    private function getChildCategories($parentId)
    {
        $categories = Category::where('parent_id', $parentId)->get();
        $result = [];

        foreach ($categories as $category) {
            $result[] = [
                'id' => $category->id,
                'name' => $category->name,
                'children' => $this->getChildCategories($category->id),
            ];
        }

        return $result;
    }
}
