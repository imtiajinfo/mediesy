<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }


    public function showRegistrationForm()
    {
        return view('auth.user-register');
    }

    public function register(Request $request)
    {
        // Validate the registration data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,manager,employee,customer',
        ]);

        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Log in the user after registration (optional)
        // auth()->login($user);

        // // Redirect to the appropriate dashboard based on the user's role
        // switch ($user->role) {
        //     case 'admin':
        //         return redirect()->route('admin.dashboard');
        //     case 'manager':
        //         return redirect()->route('manager.dashboard');
        //     case 'employee':
        //         return redirect()->route('employee.dashboard');
        //     case 'customer':
        //         return redirect()->route('customer.dashboard');
        //     default:
        //         return redirect()->route('home');
        // }
    }
}
