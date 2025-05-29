<?php

namespace App\Http\Controllers\Admin\HK;

use App\Models\Size;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();

            $perPage = $request->input('per_page', 10); // Default to 10 records per page, adjust as needed
            $search = $request->input('search');
            $status = $request->input('status'); // 'active', 'inactive', or null
            $query = Size::query()->select(
                ['id', 'name', 'name_bangla', 'size', 'description', 'logo', 'status']
            )
                ->latest('id');

            // Apply status filter
            if ($status) {
                $query->where('status' === $status);
            }

            // Apply search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    // Dynamically search across all columns
                    $fillableColumns = (new Size())->getFillable(); // Fetch all fillable columns
                    foreach ($fillableColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }

            $query = $query->paginate($perPage);
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'An error occurred.',
                'message' => $error->getMessage(),
            ], 500);
        }
        return view('admin.sizes.index', with(['query' => $query,]));
    }


    public function create()
    {
        $query = "";
        return view('admin.sizes.create', compact('query'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreSizeRequest $request)
    {
        // Generate slug from the Size name
        $slug = Str::slug($request->input('name'));

        // Add the slug to the request data
        $requestData = $request->all();
        $requestData['slug'] = $slug;

        // Create the customer record
        $data = Size::create($requestData);
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'success',
                'sizes' => $data,
            ]);
        }
        // Flash success message and redirect
        session()->flash('success', 'Size added successfully.');
        return redirect()->route('admin.sizes.index')->with('success', 'Size Inserted successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        $query = $size;
        return view('admin.sizes.view', compact('query'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        $query = $size;
        return view('admin.sizes.edit', compact('query'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSizeRequest $request, Size $size)
    {
        $size->update($request->validated());
        return redirect()->route('admin.sizes.index')->with('success', 'Size updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Size deleted successfully.');
    }
}
