<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function redirectUser(): \Illuminate\Http\RedirectResponse
    {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.homepage');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
}
