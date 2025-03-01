<?php

namespace App\Http\Controllers\Web;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function userLogin(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');

        if (Auth::guard('agents')->attempt($credentials)) {
            return redirect()->route('admin');
        }
    }

    public function agentLogin(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');

        if (Auth::guard('partner')->attempt($credentials)) {
            return redirect()->route('agent');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        
        
        if (Auth::guard('partner')->attempt($credentials)) {
            // dd("auth success");

            return redirect()->route('partner');
            // return redirect()->intended('dashboard')
            //             ->withSuccess('You have Successfully loggedin');
        }
        if (Auth::guard('user')->attempt($credentials)) {
            // dd("auth success");
            // dd(Auth::user());
            //  dd(Auth::guard('user')->check());
            return redirect()->route('admin');
            // return redirect()->intended('dashboard')
            //             ->withSuccess('You have Successfully loggedin');
        }
        if (Auth::guard('agent')->attempt($credentials)) {
            // dd(Auth::user());
            // dd(auth()->check());
            // dd("agent");
            // return redirect()->route('admin');
            // return redirect()->intended('dashboard')
            //             ->withSuccess('You have Successfully loggedin');
        }
        // else{
        //     dd("not auth success");
        // }
  
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function test()
    {
        dd(auth()->check());
        dd("Sds");
    }
}
