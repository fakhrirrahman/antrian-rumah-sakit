<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Berjalan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        .nomor-antrian {
            font-size: 50px;
            font-weight: bold;
            color: red;
        }

        .poli-info {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 10px;
        }

        .list-antrian {
            text-align: left;
            margin-top: 20px;
        }

        .list-antrian ul {
            list-style: none;
            padding: 0;
        }

        .list-antrian li {
            padding: 10px;
            background: #ddd;
            margin-bottom: 5px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Antrian Poli Umum Saat Ini</h2>
        <p>Nomor yang sedang dipanggil:</p>
        <div class="nomor-antrian" id="dipanggil">-</div>
        <p class="poli-info" id="poli-dipanggil">Poli: -</p>

        <h3>Menunggu:</h3>
        <div class="list-antrian">
            <ul id="menunggu-list">
                <li>Loading...</li>
            </ul>
        </div>
    </div>

    <script>
        function fetchAntrian() {
            fetch('/api/get-antrian-berjalan-PoliUmum')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('dipanggil').innerText = data.dipanggil ? data.dipanggil.nomor_antrian : '-';
                    document.getElementById('poli-dipanggil').innerText = data.dipanggil ? "Poli: " + data.dipanggil.poli : "Poli: -";

                    let menungguList = document.getElementById('menunggu-list');
                    menungguList.innerHTML = '';

                    if (data.menunggu.length > 0) {
                        data.menunggu.forEach(antrian => {
                            let li = document.createElement('li');
                            li.innerText = antrian.nomor_antrian + " - " + antrian.nama_pasien;
                            menungguList.appendChild(li);
                        });
                    } else {
                        menungguList.innerHTML = '<li>Tidak ada antrian menunggu</li>';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        setInterval(fetchAntrian, 3000); // Update setiap 3 detik
        fetchAntrian(); // Load pertama kali
    </script>

</body>

</html>