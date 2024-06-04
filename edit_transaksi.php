<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM transaksi WHERE id = ?");
    $stmt->execute([$id]);
    $transaksi = $stmt->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

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
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Edit Transaksi</h1>
        <form method="post" class="mt-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaksi['id']); ?>">
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
        <br>
        <a href="view_transaksi.php" class="btn btn-secondary">Kembali ke Daftar Transaksi</a>
    </div>
</body>
</html>
