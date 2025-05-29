<?php

namespace App\Http\Controllers\Admin\HK;

use Carbon\Carbon;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::latest()->paginate(10); // Paginate the results

        // return response()->json(['brands' => $brands], 200);

        return view('admin.brand.index', [
            'brands' => Brand::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $slug = str_slug($request->name_english);
            $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
            $logo_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $logo->getClientOriginalExtension();

            if (!File::exists(public_path('uploads/brand'))) {
                File::makeDirectory(public_path('uploads/brand'), 0777, true, true);
            }
            $logo->move('uploads/brand', $logo_name);
        } else {
            $logo_name = 'default.png';
        }

        // Create the brand
        $brand = Brand::create(array_merge($validatedData, ['logo' => $logo_name]));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'success',
                'brands' => $brand,
            ]);
        }
        Session::flash('message', 'Successfully created Brand!');
        return redirect()->route('admin.brands.index')->with('Successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //dd($Brand->id);
        // return view('admin.brand.brand_edit', [
        //     'Brand' => Brand::find($Brand->id),
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        $brand = $brand;
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $slug = $request->name_english;
        $logo_name = 'default.png';

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $slug = str_slug($request->name_english);
            $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
            $logo_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $logo->getClientOriginalExtension();

            if (!File::exists(public_path('uploads/brand'))) {
                File::makeDirectory(public_path('uploads/brand'), 0777, true, true);
            }
            $logo->move('uploads/brand', $logo_name);
        } elseif (!empty($brand->logo)) {
            $logo_name = $brand->logo;
        }

        $brand->name_english = $request->name_english;
        $brand->logo = $logo_name;
        $brand->save();


        Session::flash('message', 'Successfully Updated shark!');

        return redirect()->route('admin.brands.index')->with('Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index');
    }
}
