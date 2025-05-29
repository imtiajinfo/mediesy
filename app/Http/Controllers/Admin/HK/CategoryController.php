<?php

namespace App\Http\Controllers\Admin\HK;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{


    public function index(Request $request)
    {
        try {
            // dd($request->all());
            $perPage = $request->input('per_page', 10);
            $parent_id = $request->input('parent_id');
            $type = $request->input('type');

            $filters = $request->only(['search', 'type', 'status', 'per_page']);


            $query = Category::with('children')
                // ->where('name_english', 'like', "%{$request->input('search')}%")
                ->latest()
                ->filter($filters);
            if ($parent_id) {
                $query->whereIn('parent_id', [$parent_id]);
            }

            if ($type) {
                $query->where('type', $type);
            }

            $data = $query->paginate($perPage);
            // dd($data);

            if ($request->ajax()) {
                return view('admin.categories.index', [
                    'categories' => $data,
                ])->render(); // Render the view for AJAX requests
            } else {
                return view('admin.categories.index', [
                    'categories' => $data,
                ]);
            }

            // dd($categories);

            // // $perPage = $request->input('per_page', 10); // Default to 10 records per page, adjust as needed
            // $search = $request->input('search');
            // $status = $request->input('status'); // 'active', 'inactive', or null
            // // $brands =  Brand::select('name_english', 'name_bangla')->whereIn('status', [0, 1])->latest('id')->paginate(10);
            // $query = Category::query()->select('id', 'name_english', 'name_bangla', 'slug', 'paret', 'meta_title', 'meta_description', 'home_status', 'status')->whereIn('status', [0, 1])->latest('id');
            // // Apply status filter
            // if ($status) {
            //     $query->where('status' === $status);
            // }
            // // Apply search filter
            // if ($search) {
            //     $query->where(function ($query) use ($search) {
            //         $query->where('name_english', 'like', '%' . $search . '%')
            //             ->orWhere('name_bangla', 'like', '%' . $search . '%');
            //         // Add other fields as needed for searching
            //     });
            // }

            // $show = $request->input('show', 10); // Default to 10 entries per page

            // $categories = Category::paginate($show);
            // $totalEntries = Category::count();

            // if ($request->expectsJson()) {
            //     return response()->json([
            //         'showing' => $categories->count(),
            //         'total' => $totalEntries,
            //     ]);
            // }
            // return view('admin.categories.index', compact('categories'));
        } catch (\Exception $e) {
            dd($e->getMessage()); // Output the error message for debugging
        }
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories', 'categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->all();
        $slug = Str::slug($validatedData['name_english']);
        $validatedData['slug'] = $slug;
        $validatedData['created_by'] = Auth()->user()->id;

        $validatedData['status'] = $request->status ?? 0;
        $category = Category::create($validatedData);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Inserted Successfully',
                'category' => $category,
            ]);
        }


        Session::flash('message', 'Successfully created category!');
        return redirect()->route('admin.categories.index')->with('success', 'Inserted Successfullly');
    }


    public function edit(Category $category)
    {
        // return  $category;
        $categories = Category::all();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $validatedData = $request->all();
        $slug = Str::slug($validatedData['name_english']);
        $validatedData['slug'] = $slug;
        $validatedData['status'] = $request->status ?? 0;

        $category->update($validatedData);

        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        // Delete the associated logo when deleting the category
        // if ($category->logo !== 'category.png') {
        //     @Storage::disk('public')->delete($category->logo);
        // }

        Category::findOrFail($id)->delete();

        return redirect()->route('admin.categories.index');
    }
}
