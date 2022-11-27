<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function user()
    {
        return view('pages.user');
    }

    public function airline()
    {
        return view('pages.airline');
    }

    public function country()
    {
        return view('pages.country');
    }

    public function department()
    {
        return view('pages.department');
    }

    public function city()
    {
        return view('pages.city');
    }
}
