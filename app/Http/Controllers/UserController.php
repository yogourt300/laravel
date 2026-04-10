<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $users = User::orderBy('role')->orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'in:admin,collaborateur,client'],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé.');
    }

    public function edit($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'  => ['required', 'in:admin,collaborateur,client'],
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        if (auth()->id() == $id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        User::findOrFail($id)->delete();

        return back()->with('success', 'Utilisateur supprimé.');
    }
}
