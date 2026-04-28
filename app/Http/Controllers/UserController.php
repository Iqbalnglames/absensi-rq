<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // role
    public function createRole()
    {
        return view('pages.kepegawaian.createRole');
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'nama_role' => 'required',
        ]);

        if(str_contains(strtolower($request->nama_role), 'admin')){
            return redirect()->back()->with('error', 'Role ini tidak boleh dibuat!');
        }

        Role::create([
            'name' => $request->nama_role,
        ]);

        return redirect()->back()->with('success', 'Role Berhasil Disimpan');
    }
    
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('pages.kepegawaian.users', compact('users'));
    }

    public function editRole(User $user)
    {
        $roles = Role::all();

        return view('pages.kepegawaian.tambahRole', compact('user', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $user->roles()->sync($request->roles ?? []);

        return redirect()->route('kepegawaian.users.index')->with('success', 'Role berhasil diupdate');
    }

    public function create()
    {
        return view('pages.kepegawaian.createUser');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->back()->with('success', 'user berhasil dibuat');
    }

    public function edit(User $user)
    {
        return view('pages.kepegawaian.editUser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->only('name', 'username', 'email'));
        return redirect()->route('kepegawaian.users.index')->with('success', 'user berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'user berhasil dihapus');
    }
}
