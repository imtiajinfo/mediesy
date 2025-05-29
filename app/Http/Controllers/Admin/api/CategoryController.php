<?php

namespace App\Http\Controllers\Admin\api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $show = $request->input('show', 10); // Default to 10 entries per page

        $categories = Category::paginate($show);
        $totalEntries = Category::count();

        // if ($request->expectsJson()) {
        return response()->json([
            'showing' => $categories->count(),
            'total' => $totalEntries,
            'categories' => $categories,
        ]);
        // }
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories', 'categories'));
    }

    public function store(StoreCategoryRequest $request)
    {


        $validatedData = $request->validated();
        $slug = Str::slug($validatedData['name_english']);

        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = Str::slug($validatedData['name_english']) . '-' . $count;
            $count++;
        }

        $validatedData['slug'] = $slug;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('category_logos', 'public');
            $validatedData['logo'] = $logoPath;
        } else {
            $validatedData['logo'] = 'category.png';
        }

        $categorie = Category::create($validatedData);

        return response()->json([
            'message' => "created successfully",
            'categories' => $categorie,
        ], 200);
    }


    public function show(Category $category)
    {
        return response()->json([
            'message' => "created successfully",
            'categories' => $category,
        ], 200);
    }



    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $validatedData = $request->validated();

        // Generate slug from the name_english field
        $slug = Str::slug($validatedData['name_english']);

        // Check if the generated slug is unique; if not, append a number to make it unique
        $count = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = Str::slug($validatedData['name_english']) . '-' . $count;
            $count++;
        }

        $validatedData['slug'] = $slug;

        // Handle logo file upload and update
        if ($request->hasFile('logo')) {
            // Delete the old logo
            Storage::disk('public')->delete($category->logo);

            // Store the new logo
            $logoPath = $request->file('logo')->store('category_logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        $category = $category->update($validatedData);

        return response()->json([
            'message' => "udated successfully",
            'categories' => $category,
        ], 200);
    }

    public function destroy(Category $category)
    {

        if ($category->logo !== 'category.png') {
            Storage::disk('public')->delete($category->logo);
        }

        $category->delete();

        return response()->json([
            'message' => "created successfully",
            'categories' => $category,
        ], 200);
    }
}
