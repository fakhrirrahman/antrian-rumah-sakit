<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Antrian')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('ambil-antrian') }}" class="text-lg font-semibold">Sistem Antrian Rumah Sakit</a>
            <div class="space-x-4">
                <a href="{{ route('ambil-antrian') }}" class="hover:underline">Poli Gigi</a>
                <a href="{{ route('ambil-antrian-poliUmum') }}" class="hover:underline">Poli Umum</a>
                <a href="{{ route('ambil-antrian-farmasi') }}" class="hover:underline">Farmasi</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 shadow rounded-lg">
                <h2 class="text-lg font-semibold text-gray-700">Antrian Berjalan - Poli Gigi</h2>
                <p class="text-gray-600">Lihat nomor antrian yang sedang berjalan.</p>
                <a href="{{ route('antrian.berjalan') }}"
                    class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Lihat
                    Antrian</a>
            </div>
            <div class="bg-white p-4 shadow rounded-lg">
                <h2 class="text-lg font-semibold text-gray-700">Antrian Berjalan - Poli Umum</h2>
                <p class="text-gray-600">Lihat nomor antrian yang sedang berjalan.</p>
                <a href="{{ route('antrian-berjalan-poliUmum') }}"
                    class="mt-2 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Lihat
                    Antrian</a>
            </div>
            <div class="bg-white p-4 shadow rounded-lg">
                <h2 class="text-lg font-semibold text-gray-700">Antrian Berjalan - Farmasi</h2>
                <p class="text-gray-600">Lihat nomor antrian yang sedang berjalan.</p>
                <a href="{{ route('antrian.berjalan-farmasi') }}"
                    class="mt-2 inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Lihat Antrian</a>
            </div>
        </div>

        <div class="mt-6">
            @yield('content')
        </div>
    </div>
</body>

</html>