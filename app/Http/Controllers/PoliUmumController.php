<?php

namespace App\Http\Controllers;

use App\Models\PoliUmum;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

        return redirect()->route('ambil-antrian-poliUmum')->with('success', "Nomor Antrian Anda: {$antrian->nomor_antrian}");
    }

    public function antrianBerjalan()
    {
        return view('poliumum.berjalan');
    }

    public function getAntrianBerjalanPoliUmum()
    {
        $antrianDipanggil = PoliUmum::where('status', 'dipanggil')->latest('updated_at')->first();
        $antrianMenunggu = PoliUmum::where('status', 'menunggu')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'dipanggil' => $antrianDipanggil ?: null,
            'menunggu' => $antrianMenunggu,
        ]);
    }

    public function cetakNomorAntrian($id)
    {
        $antrian = PoliUmum::findOrFail($id);

        $data = [
            'nomor_antrian' => $antrian->nomor_antrian,
            'nama_pasien' => $antrian->nama_pasien,
            'poli' => $antrian->poli,
            'status' => $antrian->status,
        ];

        $pdf = Pdf::loadView('poliumum.cetak_nomor', $data);
        return $pdf->download('nomor_antrian_' . $antrian->nomor_antrian . '.pdf');
    }
}
