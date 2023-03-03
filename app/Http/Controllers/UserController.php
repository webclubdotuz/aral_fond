<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('pages.users.index', compact('roles'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required',
            'username' => 'required',
            'password' => 'required',
            'roles' => 'required',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach($request->roles);

        return redirect()->route('users.index')->with('success', 'Пользователь успешно добавлен');

    }

    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('pages.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required|unique:users,phone,'.$user->id,
            'username' => 'required|unique:users,username,'.$user->id,
            'roles' => 'required',
        ]);

        $user->update([
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('success', 'Пользователь успешно обновлен');
    }

    public function destroy($id)
    {
        alert()->error('Скоро будет реализовано');
        return redirect()->route('users.index');
    }
}
