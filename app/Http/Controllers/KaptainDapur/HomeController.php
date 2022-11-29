<?php

namespace App\Http\Controllers\KaptainDapur;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('kaptain_dapur.index');
    }
}
