<?php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM pelanggan");
$pelanggan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pelanggan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .btn-back {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Daftar Pelanggan</h2>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pelanggan as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['id']); ?></td>
                    <td><?php echo htmlspecialchars($item['nama_pelanggan']); ?></td>
                    <td><?php echo htmlspecialchars($item['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($item['telepon']); ?></td>
                    <td>
                        <a href="edit_pelanggan.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_pelanggan.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary btn-back">Kembali ke Beranda</a>
    </div>
</body>
</html>
