<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return response()->json([
            'data' => $tags,
            'total' => $tags->count()
        ], 200);
    }

    public function store(Request $request)
    {
        $name = $request->validate(['name' => 'required|string|max:255|unique:tags'])['name'];
        Tag::create(['name' => $name]);
        return response()->json(['message' => 'created'], 201);
    }
}
