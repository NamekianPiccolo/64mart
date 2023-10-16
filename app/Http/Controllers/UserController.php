<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function index()
    // {
    //     $users = User::all();
    //     return view('users.index', compact('users'));
    // }

    public function adminIndex()
    {
        $role = auth()->user()->role;
        $data_admin = User::where('role', 'admin')->get();
        return view('data_user.data_admin.index', [
            'title' => 'Admins',
            'data_admin' => $data_admin,
            'role' => $role
        ]);
    }
    public function kasirIndex()
    {
        $role = auth()->user()->role;
        $data_kasir = User::where('role', 'kasir')->get();
        return view('data_user.data_kasir.index', [
            'title' => 'Cashiers',
            'data_kasir' => $data_kasir,
            'role' => $role
        ]);
    }
    public function ownerIndex()
    {
        $role = auth()->user()->role;
        $data_owner = User::where('role', 'owner')->get();
        return view('data_user.data_owner.index', [
            'title' => 'Owners',
            'data_owner' => $data_owner,
            'role' => $role
        ]);
    }

    // public function create()
    // {
    //     return view('users.create');
    // }

    public function store(Request $request)
    {
        $role = auth()->user()->role;
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'in:admin,owner,kasir',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('data_' . $request->role)->with('success', 'Successfully added a new ' . $request->role . '.');
    }

    // public function edit(User $user)
    // {
    //     return view('users.edit', compact('user'));
    // }

    public function update(Request $request, $id)
    {
        $role = auth()->user()->role;
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'in:admin,owner,kasir',
            'password' => 'nullable|min:6',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('data_admin')->with('error', 'User not found.');
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        // if ($request->password) {
        //     $user->password = Hash::make($request->password);
        // }
        $user->save();
        return redirect()->route('data_' . $request->role)->with('success', 'Successfully updated a ' . $request->role . '.');
    }

    public function destroy(Request $request, User $user)
    {
        $role = auth()->user()->role;
        $user->delete();

        return redirect()->route('data_' . $request->role)->with('success', 'Successfully deleted a user.');
    }
}
