<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Define controller
 */
class HomeController extends Controller
{
    /**
     * @var view
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * @var view
     */
    public function create() {
        return view('admin.create');
    }

    public function list() {
        $user = Auth::user();
        return response()->json($user);
    }
}
