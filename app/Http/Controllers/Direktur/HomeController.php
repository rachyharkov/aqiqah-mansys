<?php

namespace App\Http\Controllers\Direktur;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('direktur.index');
    }
}
