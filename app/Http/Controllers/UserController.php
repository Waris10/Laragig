<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  //Show Register/Create form 
  public function create()
  {
    return view("users.register");
  }

  //New User
  public function store(Request $request)
  {
    $formFields = $request->validate([
      "name" => ['required' => 'min:3'],
      'email' => ['required', 'email', Rule::unique('users', 'email')],
      'password' => ['required', 'confirmed', 'min:6'],
    ]);

    //Hash Password
    $formFields['password'] = bcrypt($formFields['password']);

    //Create User
    $user = User::create($formFields);

    //Login
    auth()->login($user);

    return redirect('/')->with('message', 'User created and logged In Successfully');
  }

  //Logout user 
  public function logout(Request $request)
  {
    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerate();

    return redirect('/')->with('message', 'Logged out successfully');
  }

  //Show login form
  public function login()
  {
    return view('users.login');
  }

  //Authenticate User
  public function authenticate(Request $request)
  {
    $formFields = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($formFields)) {
      $request->session()->regenerate();

      return redirect('/')->with('message', 'You are now logged in');
    }
    return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
  }
}