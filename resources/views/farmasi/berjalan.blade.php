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

<body class="bg-gradient-to-br from-blue-500 to-indigo-600 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-3xl p-8 transform hover:scale-105 transition duration-500">
        <h2 class="text-4xl font-extrabold text-center text-blue-700 mb-6 uppercase">Antrian Poli Gigi</h2>
        <div class="text-center mb-8">
            <p class="text-gray-600 text-lg font-semibold">Nomor yang sedang dipanggil:</p>
            <div id="dipanggil"
                class="text-7xl font-extrabold text-red-600 animate-pulse bg-gray-100 p-6 rounded-lg shadow-lg">-</div>
        </div>
        <div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-4">Daftar Antrian:</h3>
            <div class="bg-gray-50 p-4 rounded-lg shadow-md overflow-hidden">
                <ul id="menunggu-list" class="text-gray-700 space-y-3 divide-y divide-gray-300">
                    <li class="bg-white p-4 rounded-lg shadow-md animate-pulse">Loading...</li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-6">
            <a href="javascript:history.back()"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300">Kembali</a>
        </div>
    </div>

    <script>
        function fetchAntrian() {
            fetch('/api/antrian-berjalan-farmasi')
                .then(response => response.json())
                .then(data => {
                    const dipanggilElement = document.getElementById('dipanggil');
                    dipanggilElement.innerText = data.dipanggil ? data.dipanggil.nomor_antrian : '-';
                    const menungguList = document.getElementById('menunggu-list');
                    menungguList.innerHTML = '';
                    if (data.menunggu.length > 0) {
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
                })
                .catch(error => console.error('Error:', error));
        }
        setInterval(fetchAntrian, 3000);
        fetchAntrian();
    </script>
</body>

</html>