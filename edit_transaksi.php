<?php
require 'config.php';

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM transaksi WHERE id = ?");
$stmt->execute([$id]);
$transaksi = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = intval($_POST['id_pelanggan']);
    $id_produk = intval($_POST['id_produk']);
    $jumlah = intval($_POST['jumlah']);
    
    $stmt_produk = $pdo->prepare("SELECT harga FROM produk WHERE id = ?");
    $stmt_produk->execute([$id_produk]);
    $produk = $stmt_produk->fetch();
    $total_harga = $produk['harga'] * $jumlah;

    $stmt = $pdo->prepare("UPDATE transaksi SET id_pelanggan = ?, id_produk = ?, jumlah = ?, total_harga = ?, tanggal_transaksi = NOW() WHERE id = ?");
    $stmt->execute([$id_pelanggan, $id_produk, $jumlah, $total_harga, $id]);

    echo "Transaksi berhasil diperbarui!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaksi</title>
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
                Edit Transaksi
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label>ID Pelanggan</label>
                        <input type="number" name="id_pelanggan" class="form-control" value="<?php echo htmlspecialchars($transaksi['id_pelanggan']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>ID Produk</label>
                        <input type="number" name="id_produk" class="form-control" value="<?php echo htmlspecialchars($transaksi['id_produk']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" value="<?php echo htmlspecialchars($transaksi['jumlah']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
            <div class="card-footer text-right">
                <a href="view_transaksi.php" class="btn btn-secondary">Kembali ke Daftar Transaksi</a>
            </div>
        </div>
    </div>
</body>
</html>
