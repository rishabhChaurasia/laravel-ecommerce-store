<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Send email to admin
        Mail::to(env('ADMIN_MAIL', 'admin@example.com'))->send(new ContactMail($validated));

        return redirect()->route('contact.thank-you');
    }

    public function thankYou()
    {
        return view('contact.thank-you');
    }
}
