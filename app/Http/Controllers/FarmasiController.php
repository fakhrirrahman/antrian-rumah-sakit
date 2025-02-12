<?php

namespace App\Http\Controllers;

use App\Models\Farmasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FarmasiController extends Controller
{
    public function showForm()
    {
        return view('farmasi.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required',
        ]);

        $nomor_antrian = Farmasi::generateNomorAntrian();

        $antrian = Farmasi::create([
            'nama_pasien' => $request->nama_pasien,
            'nomor_antrian' => $nomor_antrian,
            'status' => 'menunggu',
        ]);

        return redirect()->route('ambil-antrian-farmasi')->with('success', "Nomor Antrian Anda: {$antrian->nomor_antrian}");
    }

    public function antrianBerjalan()
    {
        return view('farmasi.berjalan');
    }

    public function getAntrianBerjalan()
    {
        $antrianDipanggil = Farmasi::where('status', 'dipanggil')->orderBy('updated_at', 'desc')->first();
        $antrianMenunggu = Farmasi::where('status', 'menunggu')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'dipanggil' => $antrianDipanggil,
            'menunggu' => $antrianMenunggu,
        ]);
    }

    public function cetak($id)
    {
        $farmasi = Farmasi::findOrFail($id);
        $pdf = PDF::loadView('farmasi.struk', compact('farmasi'));
        return $pdf->download('nomor_antrian_' . $farmasi->nomor_antrian . '.pdf');
    }
}
