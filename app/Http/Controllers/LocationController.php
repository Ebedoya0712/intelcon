<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Municipality;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Devuelve las ciudades de un estado específico.
     */
    public function getCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get();
        return response()->json($cities);
    }

    /**
     * Devuelve los municipios de una ciudad específica.
     */
    public function getMunicipalities(Request $request)
    {
        $municipalities = Municipality::where('city_id', $request->city_id)->get();
        return response()->json($municipalities);
    }
}

