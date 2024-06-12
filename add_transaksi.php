<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = intval($_POST['id_pelanggan']);
    $id_produk = intval($_POST['id_produk']);
    $jumlah = intval($_POST['jumlah']);

    // Ambil harga dan stok produk dari database
    $stmt_produk = $pdo->prepare("SELECT harga, stok FROM produk WHERE id = ?");
    $stmt_produk->execute([$id_produk]);
    $produk = $stmt_produk->fetch();

    // Cek apakah stok cukup
    if ($produk['stok'] >= $jumlah) {
        // Hitung total harga
        $total_harga = $produk['harga'] * $jumlah;

        // Kurangi stok produk
        $stok_baru = $produk['stok'] - $jumlah;
        $stmt_update_stok = $pdo->prepare("UPDATE produk SET stok = ? WHERE id = ?");
        $stmt_update_stok->execute([$stok_baru, $id_produk]);

        // Masukkan transaksi baru
        $stmt = $pdo->prepare("INSERT INTO transaksi (id_pelanggan, id_produk, jumlah, total_harga, tanggal_transaksi) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$id_pelanggan, $id_produk, $jumlah, $total_harga]);

        echo "Transaksi berhasil ditambahkan!";
    } else {
        echo "Stok tidak cukup untuk melakukan transaksi ini.";
    }
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
