<?php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM produk");
$produk = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lihat Produk</title>
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
        <h1 class="text-center mt-5">Daftar Produk</h1>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produk as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['id']); ?></td>
                    <td><?php echo htmlspecialchars($item['nama_produk']); ?></td>
                    <td><?php echo htmlspecialchars($item['kategori']); ?></td>
                    <td><?php echo 'Rp ' . number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($item['stok']); ?></td>
                    <td>
                        <a href="edit_produk.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_produk.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
    </div>
</body>
</html>
