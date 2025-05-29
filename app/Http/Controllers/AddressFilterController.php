<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;

class AddressFilterController extends Controller
{
    public function getDivisions(Request $request)
    {
        $countryId = $request->input('country_id');
        $divisions = Division::where('country_id', $countryId)->pluck('name', 'id');
        return response()->json($divisions);
    }

    public function getDistricts(Request $request)
    {
        $divisionId = $request->input('country_id');
        $districts = District::where('country_id', $divisionId)->pluck('name', 'id');
        return response()->json($districts);
    }

    public function getAreas(Request $request)
    {
        $cityId = $request->input('city_id');
        $areas = Area::where('district_id', $cityId)->pluck('name', 'id');
        return response()->json($areas);
    }

    public function getThana(Request $request)
    {
        $UpazilaID = $request->input('district_id');
        $upazila = Upazila::where('district_id', $UpazilaID)->pluck('name', 'id');
        return response()->json($upazila);
    }
}
