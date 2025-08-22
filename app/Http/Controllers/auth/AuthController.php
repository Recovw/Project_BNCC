<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;



class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Auth.welcome');
    }

    public function showLogin()
    {
        return view('Auth.login');
    }

    public function showRegister()
    {
        return view('Auth.register');
    }

    public function login(Request $req)
    {
        $req->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            ],
            'password' => 'required|min:6|max:12',
        ],
        [
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name cannot exceed 40 characters',
            'password.min' => 'Password must be at least 6 characters',
            'password.max' => 'Password cannot exceed 12 characters',
            'email.regex' => 'Email must be a valid @gmail.com address',
        ]);

        if (Auth::attempt($req->only('email', 'password'))) 
        {
            $req->session()->regenerate();
    
            if (Auth::user()->role === 'admin') 
            {
                return redirect()->route('createItem'); 
            } 
            else 
                {
                return redirect()->route('shop'); 
            }
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ]);
    }

    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required|min:3|max:40',
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                'unique:users,email'
            ],
            'password' => 'required|min:6|max:12|confirmed',
            'phone_number' => [
                'required',
                'regex:/^08[0-9]{8,11}$/',
                'unique:users,phone_number'
            ],
        ], 
        [
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name cannot exceed 40 characters',
            'password.min' => 'Password must be at least 6 characters',
            'password.max' => 'Password cannot exceed 12 characters',
            'email.regex' => 'Email must be a valid @gmail.com address',
            'phone_number.regex' => 'Phone number must start with 08 and be 10 to 13 digits long',
        ]);

        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'phone_number' => $req->phone_number,
        ]);

        if (Auth::attempt($req->only('email', 'password'))) 
        {
            $req->session()->regenerate(); 
            return redirect('/');
        }

        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
