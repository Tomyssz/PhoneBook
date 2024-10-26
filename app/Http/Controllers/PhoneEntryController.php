<?php

namespace App\Http\Controllers;

use App\Models\PhoneEntry;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhoneEntryController extends Controller
{
    private array $errors = [];

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user         = auth()->user();
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

        \auth()->user()->phoneEntries()->attach($phone_entry, ['main' => 1]);

        return redirect(route('phonebook.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $users              = User::where('id', '<>', auth()->id())->get();
        $phonebook_entry    = PhoneEntry::find($id);

        PhoneEntry::validateAccessRights($phonebook_entry, $this->errors);

        if (!empty($this->errors)) {
            return redirect(route('phonebook.index'))->withErrors([
                'errors' => $this->errors
            ]);
        }

        return view('phonebook.edit')->with([
            'phoneEntry' => $phonebook_entry,
            'users'      => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $phonebook_entry = PhoneEntry::find($id);

        PhoneEntry::validateAccessRights($phonebook_entry, $this->errors);

        if (!empty($this->errors)) {
            return redirect(route('phonebook.index'))->withErrors([
                'errors' => $this->errors
            ]);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/(\+[0-9]{11})/'],
            'users' => ['exists:users,id']
        ]);

        if (!empty($request->users)) {
            foreach ($request->users as $user_id) {
                $phonebook_entry->user()->attach($user_id);
            }
        }

        return redirect(route('phonebook.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $phonebook_entry = PhoneEntry::find($id);

        PhoneEntry::validateAccessRights($phonebook_entry, $this->errors);

        if (!empty($this->errors)) {
            return redirect(route('phonebook.index'))->withErrors([
                'errors' => $this->errors
            ]);
        }

        if ($phonebook_entry->exists()) {
            $phonebook_entry->delete();
        }

        return redirect(route('phonebook.index'));
    }
}
