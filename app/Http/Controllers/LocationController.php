<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return response()->json([
            'data' => $locations,
            'total' => $locations->count(),
        ], 200);
    }

    public function store(Request $request)
    {
        $name = $request->validate(['name' => 'required|string|max:255|unique:locations'])['name'];
        Location::create(['name' => $name]);

        return response()->json(['message' => 'created'], 201);
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return response()->json(['massage' => 'The request has succeeded.', 200]);
    }
}
