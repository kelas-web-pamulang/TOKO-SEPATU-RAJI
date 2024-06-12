<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = intval($_POST['harga']); 
    $stok = intval($_POST['stok']); 

    $stmt = $pdo->prepare("INSERT INTO produk (nama_produk, kategori, harga, stok) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nama_produk, $kategori, $harga, $stok]);

    echo "Produk berhasil ditambahkan!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Tambah Produk
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
            <div class="card-footer text-right">
                <a href="view_produk.php" class="btn btn-secondary">Kembali ke Daftar Produk</a>
            </div>
        </div>
    </div>
</body>
</html>
