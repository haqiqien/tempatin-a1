<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|in:user,partner',
        ]);

        $role = $request->input('role', 'user');

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $role,
            'status' => 'active',
        ]);

        if ($role === 'partner') {
            Partner::create([
                'user_id' => $user->user_id,
                'business_name' => $user->full_name,
                'contact_name' => $user->full_name,
                'contact_phone' => $user->phone,
                'status' => 'active',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
    }
}
