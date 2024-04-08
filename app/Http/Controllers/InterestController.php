<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    public function index()
    {
        $interests = Interest::all();

        return response()->json([
            'data' => $interests,
            'total' => $interests->count(),
        ], 200);
    }

    public function store(Request $request)
    {
        $name = $request->validate(['name' => 'required|string|max:255|unique:interests'])['name'];
        Interest::create(['name' => $name]);

        return response()->json(['message' => 'created'], 201);
    }
}
