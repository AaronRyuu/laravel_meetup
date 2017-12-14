<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;

class WelcomeController extends Controller
{
    public function index()
    {
        $issues = Issue::orderBy('created_at', 'desc')->take(2)->get();
        return view('welcome.index')->with('issues', $issues);
    }

    public function about()
    {
        return view('welcome.about');
    }
}