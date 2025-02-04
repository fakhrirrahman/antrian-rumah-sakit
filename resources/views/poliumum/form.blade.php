@extends('layouts.app')

@section('title', 'Ambil Nomor Antrian Poli Umum')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Ambil Nomor Antrian Poli Umum</h2>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('store-antrian-PoliUmum') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="nama_pasien" class="block text-sm font-medium text-gray-700">Nama Pasien</label>
            <input type="text" name="nama_pasien" id="nama_pasien" placeholder="Masukkan Nama" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="poli" class="block text-sm font-medium text-gray-700">Pilih Poli</label>
            <select name="poli" id="poli" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Pilih Poli</option>
                <option value="Poli 1">Poli 1</option>
                <option value="Poli 2">Poli 2</option>
                <option value="Poli 3">Poli 3</option>
            </select>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Ambil Nomor Antrian
        </button>
    </form>
</div>
@endsection