<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    $stmt_produk = $pdo->prepare("SELECT harga FROM produk WHERE id = ?");
    $stmt_produk->execute([$id_produk]);
    $produk = $stmt_produk->fetch();
    $total_harga = $produk['harga'] * $jumlah;

    $stmt = $pdo->prepare("INSERT INTO transaksi (id_pelanggan, id_produk, jumlah, total_harga, tanggal_transaksi) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$id_pelanggan, $id_produk, $jumlah, $total_harga]);

    echo "Transaksi berhasil ditambahkan!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
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
                Tambah Transaksi
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label>ID Pelanggan</label>
                        <input type="number" name="id_pelanggan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>ID Produk</label>
                        <input type="number" name="id_produk" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
            <div class="card-footer text-right">
                <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>
