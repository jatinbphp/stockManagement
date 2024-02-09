<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{
    public function adminLoginForm()
    {
        return view('admin.auth.admin_login', ['url' => route('admin.login'), 'title' => 'Admin']);
    }

    public function adminLogin(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect('/admin')->with('error', 'Only Admin Can Login Here');
            }
        } else {
            return redirect('/admin')->with('errormessage', 'Invalid Credentials');
        }
    }

    public function adminLogout()
    {
        Auth::logout();
        return redirect('admin');
    }
}
