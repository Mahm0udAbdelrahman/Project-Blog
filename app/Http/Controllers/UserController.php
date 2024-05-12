<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::withTrashed()->get();
        return view('dash.user.all', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dash.user.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required|' . Rule::in(['user' , 'admin']),
        ]);
        $allData = $request->except('password');
        $allData['password'] = Hash::make($request->password);
        User::create($allData);

        return to_route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dash.user.edit', compact('user'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable',
            'role' => 'required|' . Rule::in(['user' , 'admin']),
        ]);
        $allData = $request->except('password');
        if($request->filled('password')) {
            $allData['password'] = Hash::make($request->password);
        }
        $user->update($allData);

        return to_route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return to_route('dashboard.users.index');
    }
    public function restore(User $user)
    {
        $user->restore();
        return to_route('dashboard.users.index');
    }
    public function erase(User $user)
    {
        $user->forceDelete();
        return to_route('dashboard.users.index');
    }
}
