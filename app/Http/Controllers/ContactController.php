<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ContactResource::collection(Contact::with('location')->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        $validated = $request->safe()->except(['interest_ids']);
        $interests = $request->safe()->only(['interest_ids'])['interest_ids'];

        $contact = Contact::create($validated);
        $contact->interests()->sync($interests);

        return response()->json(['massage' => 'The request has succeeded.', 200]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {   
        return new ContactResource($contact->load('interests'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $validated = $request->safe()->except(['interest_ids']);
        $interests = $request->safe()->only(['interest_ids'])['interest_ids'];

        $contact->update($validated);
        $contact->interests()->sync($interests);

        return response()->json(['massage' => 'The request has succeeded.', 200]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return response()->json(['massage' => 'The request has succeeded.', 200]);
    }
}
