<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UomSetController extends Controller
{
    public function UOM_set()
    {
        return view('Uom_set.Uom_set_list');
    }
}
