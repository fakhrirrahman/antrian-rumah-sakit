<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Berjalan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-pulse {
            animation: pulse 1.5s infinite;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-600 to-purple-800 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Antrian Poli Gigi -->
        <div class="bg-white rounded-xl shadow-xl transform hover:scale-105 transition duration-500">
            <div class="bg-gradient-to-r from-green-400 to-green-500 text-white text-center py-4 rounded-t-xl">
                <h2 class="text-2xl font-bold uppercase">Antrian Poli Gigi</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-lg text-center font-semibold mb-4">Nomor yang sedang dipanggil:</p>
                <div id="dipanggil-gigi"
                    class="text-6xl font-extrabold text-red-600 animate-pulse bg-gray-100 p-6 rounded-lg shadow-lg text-center">
                    -
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mt-6 mb-4">Daftar Antrian:</h3>
                <div class="bg-gray-50 p-4 rounded-lg shadow-inner max-h-80 overflow-y-auto">
                    <ul id="menunggu-list-gigi" class="text-gray-700 space-y-3 divide-y divide-gray-300">
                        <li class="bg-white p-4 rounded-lg shadow-md animate-pulse">Loading...</li>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Antrian Poli Umum -->
        <div class="bg-white rounded-xl shadow-xl transform hover:scale-105 transition duration-500">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-center py-4 rounded-t-xl">
                <h2 class="text-2xl font-bold uppercase">Antrian Poli Umum</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-lg text-center font-semibold mb-4">Nomor yang sedang dipanggil:</p>
                <div id="dipanggil-umum"
                    class="text-6xl font-extrabold text-red-600 animate-pulse bg-gray-100 p-6 rounded-lg shadow-lg text-center">
                    -
                </div>
                <p id="poli-info-umum" class="text-gray-700 text-lg text-center font-semibold mt-4">
                    <!-- Informasi poli akan diisi oleh JavaScript -->
                </p>
                <h3 class="text-xl font-semibold text-gray-900 mt-6 mb-4">Daftar Antrian:</h3>
                <div class="bg-gray-50 p-4 rounded-lg shadow-inner max-h-80 overflow-y-auto">
                    <ul id="menunggu-list-umum" class="text-gray-700 space-y-3 divide-y divide-gray-300">
                        <li class="bg-white p-4 rounded-lg shadow-md animate-pulse">Loading...</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Antrian Farmasi -->
        <div class="bg-white rounded-xl shadow-xl transform hover:scale-105 transition duration-500">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white text-center py-4 rounded-t-xl">
                <h2 class="text-2xl font-bold uppercase">Antrian Farmasi</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-lg text-center font-semibold mb-4">Nomor yang sedang dipanggil:</p>
                <div id="dipanggil-farmasi"
                    class="text-6xl font-extrabold text-red-600 animate-pulse bg-gray-100 p-6 rounded-lg shadow-lg text-center">
                    -
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mt-6 mb-4">Daftar Antrian:</h3>
                <div class="bg-gray-50 p-4 rounded-lg shadow-inner max-h-80 overflow-y-auto">
                    <ul id="menunggu-list-farmasi" class="text-gray-700 space-y-3 divide-y divide-gray-300">
                        <li class="bg-white p-4 rounded-lg shadow-md animate-pulse">Loading...</li>
                    </ul>
                </div>
            </div>
        </div>


        <script>
            async function fetchAntrian(poli, endpoint) {
                try {
                    const response = await fetch(endpoint);
                    if (!response.ok) throw new Error(`Gagal mengambil data antrian ${poli}`);
        
                    const data = await response.json();
        
                    // Update elemen "dipanggil"
                    const dipanggilElement = document.getElementById(`dipanggil-${poli}`);
                    dipanggilElement.innerText = data.dipanggil ? data.dipanggil.nomor_antrian : '-';
        
                    // Update informasi poli (khusus Poli Umum)
                    if (poli === 'umum') {
                        const poliInfoElement = document.getElementById('poli-info-umum');
                        poliInfoElement.innerText = data.dipanggil ? `Poli: ${data.dipanggil.poli}` : 'Poli: -';
                    }
        
                    // Update daftar "menunggu"
                    const menungguList = document.getElementById(`menunggu-list-${poli}`);
                    menungguList.innerHTML = '';
        
                    if (data.menunggu && data.menunggu.length > 0) {
                        data.menunggu.forEach(antrian => {
                            const li = document.createElement('li');
                            li.className = 'bg-white p-4 rounded-lg shadow-md hover:bg-gray-200 transition duration-300';
                            li.innerText = `Nomor ${antrian.nomor_antrian} - ${antrian.nama_pasien}`;
                            menungguList.appendChild(li);
                        });
                    } else {
                        const li = document.createElement('li');
                        li.className = 'bg-white p-4 rounded-lg shadow-md';
                        li.innerText = 'Tidak ada antrian menunggu';
                        menungguList.appendChild(li);
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        
            function initializeFetch() {
                fetchAntrian('gigi', '/api/antrian-berjalan');
                fetchAntrian('farmasi', '/api/antrian-berjalan-farmasi');
                fetchAntrian('umum', '/api/get-antrian-berjalan-PoliUmum');
            }
        
            // Panggil fungsi fetch setiap 3 detik
            setInterval(() => {
                initializeFetch();
            }, 3000);
        
            // Ambil data antrian pertama kali saat halaman dimuat
            initializeFetch();
        </script>
</body>

</html>