<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Nomor Antrian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-semibold mb-4 text-center text-blue-600">Ambil Nomor Antrian</h2>

        @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded-md mb-4 text-center">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('store-antrian-PoliUmum') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                <input type="text" name="nama_pasien" placeholder="Masukkan Nama" required
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Pilih Poli</label>
                <select name="poli" required
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Pilih Poli</option>
                    <option value="Poli_1">Poli 1</option>
                    <option value="Poli_2">Poli 2</option>
                    <option value="Poli_3">Poli 3</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                Ambil Nomor Antrian
            </button>
        </form>
    </div>

</body>

</html>