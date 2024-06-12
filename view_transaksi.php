<?php
require 'config.php';

$stmt = $pdo->query("SELECT t.id, p.nama_pelanggan, pr.nama_produk, t.jumlah, t.total_harga, t.tanggal_transaksi 
                     FROM transaksi t 
                     JOIN pelanggan p ON t.id_pelanggan = p.id 
                     JOIN produk pr ON t.id_produk = pr.id");
$transaksi = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lihat Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Daftar Transaksi</h1>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pelanggan</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal Transaksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['id']); ?></td>
                    <td><?php echo htmlspecialchars($item['nama_pelanggan']); ?></td>
                    <td><?php echo htmlspecialchars($item['nama_produk']); ?></td>
                    <td><?php echo htmlspecialchars($item['jumlah']); ?></td>
                    <td><?php echo 'Rp ' . number_format($item['total_harga'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($item['tanggal_transaksi']); ?></td>
                    <td>
                        <a href="edit_transaksi.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_transaksi.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
    </div>
</body>
</html>
