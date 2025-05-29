<?php

namespace App\Http\Controllers\Admin\HK;

use App\Models\BankInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreBankInfoRequest;
use App\Http\Requests\UpdateBankInfoRequest;

class BankInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search');

            $filters = $request->only(['search', 'per_page']);

            $query = BankInfo::latest('id');
            $data = $query->paginate($perPage);

            return view('admin.bankInfo.index', ['bankInfos' => $data]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bankInfo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankInfoRequest $request)
    {
        $validatedData = $request->validated();

        $bankInfo = BankInfo::create($validatedData);
        // Save the changes
        $bankInfo->save();

        // Flash success message
        Session::flash('success', 'Successfully created bankInfo!');
        // Redirect to the index route with a success message
        return redirect()->route('admin.bankInfo.index')->with(['success' => 'Successfully created']);
    }


    /**
     * Display the specified resource.
     */
    public function show(BankInfo $bankInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankInfo $bankInfo)
    {
        $bankInfo = $bankInfo;
        // dd($bankInfo);
        return view('admin.bankInfo.edit', with(['bankInfo' => $bankInfo]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankInfoRequest $request, BankInfo $bankInfo)
    {
        $bankInfo->update($request->validated());
        return redirect()->route('admin.bankInfo.index')->with('success', 'bankInfo updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankInfo $bankInfo)
    {
        $bankInfo->delete();
        return redirect()->route('admin.bankInfo.index')->with('success', 'bankInfo deleted successfully.');
    }
}
