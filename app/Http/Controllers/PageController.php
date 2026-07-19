<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * About page.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Contact page.
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission (flash only — no DB needed).
     */
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'Your name is required.',
            'email.required'   => 'Your email is required.',
            'email.email'      => 'Please enter a valid email address.',
            'message.required' => 'Please write a message.',
        ]);

        return redirect()->route('contact')
                         ->with('success', 'Thank you! Your message has been received.');
    }

    /**
     * Save theme preference cookie (light/dark) — expires in 7 days.
     */
    public function setTheme(Request $request)
    {
        $theme = $request->input('theme', 'light') === 'dark' ? 'dark' : 'light';

        return response()->json(['success' => true, 'theme' => $theme])
            ->cookie('theme_preference', $theme, 60 * 24 * 7);
    }
}
