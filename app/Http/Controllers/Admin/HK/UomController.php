<?php

namespace App\Http\Controllers\Admin\HK;

use App\Models\Uom;
use App\Models\Uomset;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUomRequest;
use App\Http\Requests\UpdateUomRequest;
use Illuminate\Support\Facades\Session;

class UomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uoms = Uom::latest()->paginate(10); // Paginate the results

        // return response()->json(['uoms' => $uoms], 200);

        return view('admin.uom.index', [
            'uoms' => Uom::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $uomsets  = Uomset::all();
        return view('admin.uom.create', with(['uomsets' => $uomsets]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUomRequest $request)
    {
        $validatedData = $request->validated();

        // Merge the validated data with additional data
        $data = array_merge($validatedData, [
            'uom_set_id' => 0,
            'uom_desc' => $request->uom_desc ?? "0",
            'relative_factor' => $request->relative_factor ?? "0",
            'fraction_allow' => $request->fraction_allow ?? "0",
        ]);

        $uom = Uom::create($data);

        // Save the changes
        $uom->save();

        // Flash success message
        Session::flash('success', 'Successfully created uom!');

        // Redirect to the index route with a success message
        return redirect()->route('admin.uoms.index')->with(['success' => 'Successfully created']);
    }


    /**
     * Display the specified resource.
     */
    public function show(Uom $uom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Uom $uom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUomRequest $request, Uom $uom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Uom $uom)
    {
        $uom->delete();
        return redirect()->route('admin.uoms.index')->with('success', 'UOM deleted successfully.');
    }
}
