<?php

namespace App\Http\Controllers\Ppic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('ppic.index');
    }
}
