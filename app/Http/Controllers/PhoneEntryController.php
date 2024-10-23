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
        $phoneEntries = $user->phoneEntries()->get();

        return view('phonebook.index')->with([
            'phoneEntries' => $phoneEntries
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/(\+[0-9]{11})/'],
        ]);

        $phone_entry = PhoneEntry::create([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        \auth()->user()->phoneEntries()->attach($phone_entry);

        return redirect(route('phonebook.index'));
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
    public function destroy($id)
    {
        $phoneEntry = PhoneEntry::find($id);

        if ($phoneEntry->exists()) {
            $phoneEntry->delete();
        }

        return redirect(route('phonebook.index'));
    }
}
