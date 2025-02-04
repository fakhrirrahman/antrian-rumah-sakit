<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use Barryvdh\DomPDF\Facade\Pdf;

class AntrianController extends Controller
{
    public function showForm()
    {
        return view('antrian.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required',
        ]);

        $nomor_antrian = Antrian::generateNomorAntrian();

        $antrian = Antrian::create([
            'nama_pasien' => $request->nama_pasien,
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
        $antrianDipanggil = Antrian::where('status', 'dipanggil')->orderBy('updated_at', 'desc')->first();
        $antrianMenunggu = Antrian::where('status', 'menunggu')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'dipanggil' => $antrianDipanggil,
            'menunggu' => $antrianMenunggu,
        ]);
    }
    public function print($id)
    {
        $antrian = Antrian::findOrFail($id);

        // Misalnya kita menggunakan PDF, bisa diganti dengan tampilan HTML jika perlu
        $pdf = PDF::loadView('antrian.print', compact('antrian'));

        // Menghasilkan dan mengunduh file PDF
        return $pdf->download('nomor_antrian_' . $antrian->nomor_antrian . '.pdf');
    }
}
