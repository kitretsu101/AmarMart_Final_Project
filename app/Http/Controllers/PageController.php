<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
   
    public function about()
    {
        return view('about');
    }

   
    public function contact()
    {
        return view('contact');
    }

    
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

   
    public function setTheme(Request $request)
    {
        $theme = $request->input('theme', 'light') === 'dark' ? 'dark' : 'light';

        return response()->json(['success' => true, 'theme' => $theme])
            ->cookie('theme_preference', $theme, 60 * 24 * 7);
    }
}
