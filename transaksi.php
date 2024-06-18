<?php
require 'config.php';
require 'vendor/autoload.php'; // Path to your Composer autoload.php

use Sentry\SentrySdk;

\Sentry\init([
  'dsn' => 'https://2dfc0fa4bce6fe2c740b458a3b8d7e97@o4507451047477248.ingest.us.sentry.io/4507451380858880',
  // Specify a fixed sample rate
  'traces_sample_rate' => 1.0,
  // Set a sampling rate for profiling - this is relative to traces_sample_rate
  'profiles_sample_rate' => 1.0,
]);

// Function to log errors
function logError($message) {
    error_log($message . "\n", 3, "error.log");
}

// Handle Add Transaksi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_transaksi'])) {
    try {
        $id_pelanggan = intval($_POST['id_pelanggan']);
        $id_produk = intval($_POST['id_produk']);
        $jumlah = intval($_POST['jumlah']);

        $stmt_produk = $pdo->prepare("SELECT harga, stok FROM produk WHERE id = ?");
        $stmt_produk->execute([$id_produk]);
        $produk = $stmt_produk->fetch();

        if ($produk['stok'] >= $jumlah) {
            $total_harga = $produk['harga'] * $jumlah;
            $stok_baru = $produk['stok'] - $jumlah;

            $stmt_update_stok = $pdo->prepare("UPDATE produk SET stok = ? WHERE id = ?");
            $stmt_update_stok->execute([$stok_baru, $id_produk]);

            $stmt = $pdo->prepare("INSERT INTO transaksi (id_pelanggan, id_produk, jumlah, total_harga, tanggal_transaksi) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$id_pelanggan, $id_produk, $jumlah, $total_harga]);

            echo "Transaksi berhasil ditambahkan!";
        } else {
            echo "Stok tidak cukup untuk melakukan transaksi ini.";
        }
    } catch (Exception $e) {
        logError("Error adding transaction: " . $e->getMessage());
        echo "Terjadi kesalahan saat menambahkan transaksi.";
    }
}

// Handle Edit Transaksi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_transaksi'])) {
    try {
        $id = intval($_POST['id']);
        $id_pelanggan = intval($_POST['id_pelanggan']);
        $id_produk = intval($_POST['id_produk']);
        $jumlah_baru = intval($_POST['jumlah']);
        
        $stmt_transaksi = $pdo->prepare("SELECT * FROM transaksi WHERE id = ?");
        $stmt_transaksi->execute([$id]);
        $transaksi = $stmt_transaksi->fetch();
        $jumlah_lama = $transaksi['jumlah'];

        $stmt_produk = $pdo->prepare("SELECT harga, stok FROM produk WHERE id = ?");
        $stmt_produk->execute([$id_produk]);
        $produk = $stmt_produk->fetch();

        if ($produk) {
            $total_harga = $produk['harga'] * $jumlah_baru;
            $perubahan_stok = $jumlah_lama - $jumlah_baru;
            $stok_baru = $produk['stok'] + $perubahan_stok;

            $stmt_update_stok = $pdo->prepare("UPDATE produk SET stok = ? WHERE id = ?");
            $stmt_update_stok->execute([$stok_baru, $id_produk]);

            $stmt = $pdo->prepare("UPDATE transaksi SET id_pelanggan = ?, id_produk = ?, jumlah = ?, total_harga = ?, tanggal_transaksi = NOW() WHERE id = ?");
            $stmt->execute([$id_pelanggan, $id_produk, $jumlah_baru, $total_harga, $id]);

            echo "Transaksi berhasil diperbarui!";
        } else {
            echo "Produk tidak ditemukan.";
        }
    } catch (Exception $e) {
        logError("Error updating transaction: " . $e->getMessage());
        echo "Terjadi kesalahan saat memperbarui transaksi.";
    }
}

// Handle Delete Transaksi
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_transaksi'])) {
    try {
        $id = intval($_GET['id']);
        $stmt = $pdo->prepare("DELETE FROM transaksi WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: ?view_transaksi");
        exit;
    } catch (Exception $e) {
        logError("Error deleting transaction: " . $e->getMessage());
        echo "Terjadi kesalahan saat menghapus transaksi.";
    }
}

// Fetch Data for Viewing
$transaksi = [];
if (isset($_GET['view_transaksi'])) {
    try {
        $stmt = $pdo->query("SELECT t.id, p.nama_pelanggan, pr.nama_produk, t.jumlah, t.total_harga, t.tanggal_transaksi 
                             FROM transaksi t 
                             JOIN pelanggan p ON t.id_pelanggan = p.id 
                             JOIN produk pr ON t.id_produk = pr.id");
        $transaksi = $stmt->fetchAll();
    } catch (Exception $e) {
        logError("Error fetching transactions: " . $e->getMessage());
        echo "Terjadi kesalahan saat mengambil data transaksi.";
    }
}

// Fetch Data for Editing
$transaksi_edit = null;
if (isset($_GET['edit_transaksi'])) {
    try {
        $id = intval($_GET['edit_transaksi']);
        $stmt = $pdo->prepare("SELECT * FROM transaksi WHERE id = ?");
        $stmt->execute([$id]);
        $transaksi_edit = $stmt->fetch();
    } catch (Exception $e) {
        SentrySdk::captureException($e);
        logError("Error fetching transaction for edit: " . $e->getMessage());
        echo "Terjadi kesalahan saat mengambil data transaksi untuk diedit.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card, .table-container {
            margin-top: 20px;
        }
        .form-container {
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
        input[type="text"], input[type="number"] {
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
        <?php if (isset($_GET['add_transaksi'])): ?>
            <div class="form-container">
                <h2>Tambah Transaksi</h2>
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
                    <button type="submit" class="btn btn-primary" name="add_transaksi">Tambah</button>
                    <a href="?view_transaksi" class="btn btn-secondary btn-back">Kembali ke Daftar Transaksi</a>
                </form>
            </div>
        <?php elseif (isset($_GET['edit_transaksi'])): ?>
            <div class="form-container">
                <h2>Edit Transaksi</h2>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaksi_edit['id']); ?>">
                    <div class="form-group">
                        <label>ID Pelanggan</label>
                        <input type="number" name="id_pelanggan" class="form-control" value="<?php echo htmlspecialchars($transaksi_edit['id_pelanggan']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>ID Produk</label>
                        <input type="number" name="id_produk" class="form-control" value="<?php echo htmlspecialchars($transaksi_edit['id_produk']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" value="<?php echo htmlspecialchars($transaksi_edit['jumlah']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="edit_transaksi">Perbarui</button>
                    <a href="?view_transaksi" class="btn btn-secondary btn-back">Kembali ke Daftar Transaksi</a>
                </form>
            </div>
        <?php elseif (isset($_GET['view_transaksi'])): ?>
            <div class="table-container">
                <h2>Daftar Transaksi</h2>
                <table class="table table-striped">
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
                                    <a href="?edit_transaksi=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?delete_transaksi=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="index.php" class="btn btn-secondary btn-view">Kembali ke Beranda</a>
            </div>
        <?php else: ?>
            <div class="text-center">
                <h1>Welcome to the Management System</h1>
                <a href="?view_transaksi" class="btn btn-primary mt-4">Lihat Daftar Transaksi</a>
                <a href="?add_transaksi" class="btn btn-success mt-4">Tambah Transaksi</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
