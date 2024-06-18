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

// Mengatur logging kesalahan
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
error_reporting(E_ALL);

// Handle Pelanggan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_pelanggan'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    if (!empty($nama_pelanggan)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO pelanggan (nama_pelanggan, alamat, telepon) VALUES (?, ?, ?)");
            $stmt->execute([$nama_pelanggan, $alamat, $telepon]);
            echo "Pelanggan berhasil ditambahkan!";
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "Terjadi kesalahan saat menambahkan pelanggan.";
        }
    } else {
        echo "Nama pelanggan harus diisi.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_pelanggan'])) {
    $id = $_POST['id'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    if (!empty($nama_pelanggan)) {
        try {
            $stmt = $pdo->prepare("UPDATE pelanggan SET nama_pelanggan = ?, alamat = ?, telepon = ? WHERE id = ?");
            $stmt->execute([$nama_pelanggan, $alamat, $telepon, $id]);
            echo "Pelanggan berhasil diperbarui!";
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "Terjadi kesalahan saat memperbarui pelanggan.";
        }
    } else {
        echo "Nama pelanggan harus diisi.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_pelanggan'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM pelanggan WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: ?view_pelanggan");
        exit;
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Terjadi kesalahan saat menghapus pelanggan.";
    }
}

// Handle Produk
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_produk'])) {
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = intval($_POST['harga']);
    $stok = intval($_POST['stok']);

    try {
        $stmt = $pdo->prepare("INSERT INTO produk (nama_produk, kategori, harga, stok) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama_produk, $kategori, $harga, $stok]);
        echo "Produk berhasil ditambahkan!";
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Terjadi kesalahan saat menambahkan produk.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_produk'])) {
    $id = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = intval($_POST['harga']);
    $stok = intval($_POST['stok']);

    try {
        $stmt = $pdo->prepare("UPDATE produk SET nama_produk = ?, kategori = ?, harga = ?, stok = ? WHERE id = ?");
        $stmt->execute([$nama_produk, $kategori, $harga, $stok, $id]);
        echo "Produk berhasil diperbarui!";
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Terjadi kesalahan saat memperbarui produk.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_produk'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM produk WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: ?view_produk");
        exit;
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Terjadi kesalahan saat menghapus produk.";
    }
}

// Fetch Data for Viewing
$pelanggan = [];
$produk = [];

try {
    if (isset($_GET['view_pelanggan'])) {
        $stmt = $pdo->query("SELECT * FROM pelanggan");
        $pelanggan = $stmt->fetchAll();
    }

    if (isset($_GET['view_produk'])) {
        $stmt = $pdo->query("SELECT * FROM produk");
        $produk = $stmt->fetchAll();
    }
} catch (Exception $e) {
    SentrySdk::captureException($e);
    error_log($e->getMessage());
    echo "Terjadi kesalahan saat mengambil data.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
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
        .table-container {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_GET['add_pelanggan']) || isset($_GET['edit_pelanggan'])): ?>
            <div class="form-container">
                <h2><?php echo isset($_GET['edit_pelanggan']) ? 'Edit' : 'Tambah'; ?> Pelanggan</h2>
                <form method="post">
                    <?php if (isset($_GET['edit_pelanggan'])): 
                        try {
                            $stmt = $pdo->prepare("SELECT * FROM pelanggan WHERE id = ?");
                            $stmt->execute([$_GET['edit_pelanggan']]);
                            $pelanggan = $stmt->fetch();
                        } catch (Exception $e) {
                            error_log($e->getMessage());
                            echo "Terjadi kesalahan saat mengambil data pelanggan.";
                        }
                    ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($pelanggan['id']); ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="nama_pelanggan">Nama Pelanggan:</label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" value="<?php echo isset($pelanggan['nama_pelanggan']) ? htmlspecialchars($pelanggan['nama_pelanggan']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat:</label>
                        <input type="text" id="alamat" name="alamat" class="form-control" value="<?php echo isset($pelanggan['alamat']) ? htmlspecialchars($pelanggan['alamat']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon:</label>
                        <input type="text" id="telepon" name="telepon" class="form-control" value="<?php echo isset($pelanggan['telepon']) ? htmlspecialchars($pelanggan['telepon']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="<?php echo isset($_GET['edit_pelanggan']) ? 'edit_pelanggan' : 'add_pelanggan'; ?>"><?php echo isset($_GET['edit_pelanggan']) ? 'Perbarui' : 'Tambah'; ?> Pelanggan</button>
                    <a href="?view_pelanggan" class="btn btn-secondary btn-back">Kembali ke Daftar Pelanggan</a>
                </form>
            </div>
        <?php elseif (isset($_GET['add_produk']) || isset($_GET['edit_produk'])): ?>
            <div class="form-container">
                <h2><?php echo isset($_GET['edit_produk']) ? 'Edit' : 'Tambah'; ?> Produk</h2>
                <form method="post">
                    <?php if (isset($_GET['edit_produk'])): 
                        try {
                            $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
                            $stmt->execute([$_GET['edit_produk']]);
                            $produk = $stmt->fetch();
                        } catch (Exception $e) {
                            error_log($e->getMessage());
                            echo "Terjadi kesalahan saat mengambil data produk.";
                        }
                    ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($produk['id']); ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk:</label>
                        <input type="text" id="nama_produk" name="nama_produk" class="form-control" value="<?php echo isset($produk['nama_produk']) ? htmlspecialchars($produk['nama_produk']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori:</label>
                        <input type="text" id="kategori" name="kategori" class="form-control" value="<?php echo isset($produk['kategori']) ? htmlspecialchars($produk['kategori']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga:</label>
                        <input type="number" id="harga" name="harga" class="form-control" value="<?php echo isset($produk['harga']) ? htmlspecialchars($produk['harga']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok:</label>
                        <input type="number" id="stok" name="stok" class="form-control" value="<?php echo isset($produk['stok']) ? htmlspecialchars($produk['stok']) : ''; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="<?php echo isset($_GET['edit_produk']) ? 'edit_produk' : 'add_produk'; ?>"><?php echo isset($_GET['edit_produk']) ? 'Perbarui' : 'Tambah'; ?> Produk</button>
                    <a href="?view_produk" class="btn btn-secondary btn-back">Kembali ke Daftar Produk</a>
                </form>
            </div>
        <?php elseif (isset($_GET['view_pelanggan'])): ?>
            <div class="table-container">
                <h2>Daftar Pelanggan</h2>
                <table class="table table-striped">
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
                                    <a href="?edit_pelanggan=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?delete_pelanggan=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="?add_pelanggan" class="btn btn-success">Tambah Pelanggan</a>
                <a href="index.php" class="btn btn-secondary btn-view">Kembali ke Beranda</a>
            </div>
        <?php elseif (isset($_GET['view_produk'])): ?>
            <div class="table-container">
                <h2>Daftar Produk</h2>
                <table class="table table-striped">
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
                                    <a href="?edit_produk=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?delete_produk=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="?add_produk" class="btn btn-success">Tambah Produk</a>
                <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
            </div>
        <?php else: ?>
            <div class="text-center">
                <h1>Welcome to the Management System</h1>
                <a href="?view_pelanggan" class="btn btn-primary mt-4">Lihat Daftar Pelanggan</a>
                <a href="?view_produk" class="btn btn-primary mt-4">Lihat Daftar Produk</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
