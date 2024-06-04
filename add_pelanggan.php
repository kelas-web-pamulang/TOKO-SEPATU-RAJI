<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    if (!empty($nama_pelanggan)) {
        $stmt = $pdo->prepare("INSERT INTO pelanggan (nama_pelanggan, alamat, telepon) VALUES (?, ?, ?)");
        $stmt->execute([$nama_pelanggan, $alamat, $telepon]);

        echo "Pelanggan berhasil ditambahkan!";
    } else {
        echo "Nama pelanggan harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelanggan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        form {
            max-width: 400px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .btn-back, .btn-view {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Pelanggan Baru</h2>
        <form method="post">
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan:</label>
                <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" class="form-control">
            </div>
            <div class="form-group">
                <label for="telepon">Telepon:</label>
                <input type="text" id="telepon" name="telepon" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Tambah Pelanggan</button>
            <a href="index.php" class="btn btn-secondary btn-back">Kembali ke Beranda</a>
        </form>
    </div>
</body>
</html>
