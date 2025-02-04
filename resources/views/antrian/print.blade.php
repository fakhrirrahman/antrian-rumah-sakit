<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Nomor Antrian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 50px;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .nomor-antrian {
            font-size: 50px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .detail {
            font-size: 18px;
            color: #34495e;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #7f8c8d;
        }

        .divider {
            margin: 20px 0;
            border-top: 2px solid #e74c3c;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">Nomor Antrian Poli Gigi</div>
        <div class="nomor-antrian">
            {{ $antrian->nomor_antrian }}
        </div>
        <div class="detail">
            <p>Nama Pasien: {{ $antrian->nama_pasien }}</p>
        </div>
        <div class="divider"></div>
        <div class="footer">
            <p>Terima kasih telah datang</p>
        </div>
    </div>
</body>

</html>