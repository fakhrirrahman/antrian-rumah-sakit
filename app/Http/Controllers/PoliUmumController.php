<?php

namespace App\Http\Controllers;

use App\Models\PoliUmum;
use Illuminate\Http\Request;

class PoliUmumController extends Controller
{
    public function showForm()
    {
        return view('poliumum.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required',
            'poli' => 'required',
        ]);

        $nomor_antrian = PoliUmum::generateNomorAntrian();

        $antrian = PoliUmum::create([
            'nama_pasien' => $request->nama_pasien,
            "poli" => $request->poli,
            'nomor_antrian' => $nomor_antrian,
            'status' => 'menunggu',
        ]);

        return redirect()->route('ambil-antrian')->with('success', "Nomor Antrian Anda: {$antrian->nomor_antrian}");
    }

    public function antrianBerjalan()
    {
        return view('antrian.berjalan');
    }

    public function getAntrianBerjalan()
    {
        $antrianDipanggil = PoliUmum::where('status', 'dipanggil')->orderBy('updated_at', 'desc')->first();
        $antrianMenunggu = PoliUmum::where('status', 'menunggu')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'dipanggil' => $antrianDipanggil,
            'menunggu' => $antrianMenunggu,
        ]);
    }
}
