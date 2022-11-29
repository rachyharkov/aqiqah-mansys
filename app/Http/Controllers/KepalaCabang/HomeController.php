<?php

namespace App\Http\Controllers\KepalaCabang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserCabang;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('kepala_cabang.index');
    }
}
