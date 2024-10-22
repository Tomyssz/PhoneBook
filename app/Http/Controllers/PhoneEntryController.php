<?php

namespace App\Http\Controllers;

use App\Models\PhoneEntry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhoneEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user    = auth()->user();
        $entries = $user->phoneEntries()->get();

        return view('phonebook.index')->with([
            'entries' => $entries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('phonebook.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PhoneEntry $phoneEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhoneEntry $phoneEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhoneEntry $phoneEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhoneEntry $phoneEntry)
    {
        //
    }
}
