<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Nomor Antrian</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { max-width: 400px; margin: auto; padding: 20px; }
        .success { color: green; font-size: 20px; }
        .btn { background: blue; color: white; padding: 10px; border: none; cursor: pointer; }
        .btn:hover { background: darkblue; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ambil Nomor Antrian</h2>
        @if(session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif
        <form action="{{ route('ambil-antrian.store') }}" method="POST">
            @csrf
            <input type="text" name="nama_pasien" placeholder="Masukkan Nama" required>
            <button type="submit" class="btn">Ambil Antrian</button>
        </form>
    </div>
</body>
</html>
