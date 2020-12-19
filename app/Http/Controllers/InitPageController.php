<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InitPageController extends Controller
{
    public function init()
    {
        return view('init');
    }
}
