<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate(['page' => 'sometimes|numeric']);

        $page = ((int)$request->page) ?? 1;
        $totalPages = ceil(Contact::count() / 15);
        $data = Contact::skip(($page - 1) * 15)->take(15)->get();
        
        $response = [
            'data' => $data,
            'total' => $data->count(),
            'page' => $page,
            'total_pages' => $totalPages
        ];

        return response()->json($response, 200); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        $validated = $request->safe()->except(['interests']);
        $interests = $request->safe()->only(['interests'])['interests'];

        $contact = Contact::create($validated);

        $contact->interests()->sync($interests);
        return response()->json(['massage' => 'OK', 200]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {   
        if($contact) {
            $contact->append('interests');
            return response()->json($contact); 
        }
        else
            return response()->json(['massage' => 'not found'], 404); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $validated = $request->safe()->except(['interests']);
        $interests = $request->safe()->only(['interests'])['interests'];

        $contact->update($validated);
        $contact->interests()->sync($interests);
        return response()->json(['massage' => 'OK', 200]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        if($contact) {
            $contact->delete();
            return response()->json(['massage' => 'OK', 200]);
        }

        else {
            return response()->json(['massage' => 'OK', 200])   ;
        }

    }
}
