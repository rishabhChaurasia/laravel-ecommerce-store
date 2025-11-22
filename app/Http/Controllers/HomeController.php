<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (Auth::check()) {
            // If user is authenticated, redirect based on role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            // If not authenticated, redirect to welcome page
            return redirect('/');
        }
    }
}
