<?php

namespace App\Http\Controllers\Admin\HK;

use App\Models\Color;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreColorRequest;
use App\Http\Requests\UpdateColorRequest;

class ColorController extends Controller
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
            $query = Color::query()->select(
                ['id', 'name_english', 'name_bangla', 'code', 'description', 'status']
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
                    $fillableColumns = (new Color())->getFillable(); // Fetch all fillable columns
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
        return view('admin.colors.index', with(['query' => $query,]));
    }


    public function create()
    {
        $query = "";
        return view('admin.colors.create', compact('query'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreColorRequest $request)
    {
        // Generate slug from the Color name
        $slug = Str::slug($request->input('name'));

        // Add the slug to the request data
        $requestData = $request->all();
        $requestData['slug'] = $slug;

        // Create the customer record
        Color::create($requestData);

        // Flash success message and redirect
        session()->flash('success', 'Color added successfully.');
        return redirect()->route('admin.colors.index')->with('success', 'Color Inserted successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        $query = $color;
        return view('admin.colors.view', compact('query'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        $query = $color;
        return view('admin.colors.edit', compact('query'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $request, Color $color)
    {
        $color->update($request->validated());
        return redirect()->route('admin.colors.index')->with('success', 'Color updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Color deleted successfully.');
    }
}
