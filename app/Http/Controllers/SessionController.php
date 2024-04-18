<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Klien;
use App\Models\User;

class SessionController extends Controller
{
    function loginadmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('admin/dashboard');
        } else {
            return redirect('admin')->with('error', 'Email atau password salah')->withInput();
        }
    }

    function loginklien(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $klienId = $request->input('id');
        $klien = Klien::find($klienId);
        $credentials = [
            'email' => 'klien' . $klien->id . '@klien.com',
            'password' => 'klien' . $klien->id,
        ];
        if (Auth::attempt($credentials)) {
            return redirect('/klien/dashboard');
        } else {
            return redirect('/klien')->with('error', 'Login failed. Please try again.')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
