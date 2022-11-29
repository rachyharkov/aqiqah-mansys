<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Paket\{
    Nasi,
    Olahan,
    JenisPaket,
    JenisPaketNasi
};

class OlahanController extends Controller
{
    public function getOlahan(Request $request)
    {
        return Olahan::where([
            ['is_utama', true],
            ['olahan_kategori_id', $request->olahan_kategori_id]
        ])
        ->latest()->get();
    }

    public function getOlahanJeroan()
    {
        return OlahanJeroan::where('is_utama', true)->latest()->get();
    }

    public function getMenuPilihan(Request $request)
    {
        return JenisPaket::where('id', $request->jenis_paket_id)->latest()->first();
    }

    public function getNasi(Request $request)
    {
        return JenisPaketNasi::where('jenis_paket_id', $request->jenis_paket_id)->with('nasi')->latest()->get();
    }
}
