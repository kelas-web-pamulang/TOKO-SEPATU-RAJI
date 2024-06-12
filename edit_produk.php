<?php
require 'config.php';

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = intval($_POST['harga']);
    $stok = intval($_POST['stok']);

    $stmt = $pdo->prepare("UPDATE produk SET nama_produk = ?, kategori = ?, harga = ?, stok = ? WHERE id = ?");
    $stmt->execute([$nama_produk, $kategori, $harga, $stok, $id]);

    echo "Produk berhasil diperbarui!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
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
                Edit Produk
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="<?php echo htmlspecialchars($produk['nama_produk']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="<?php echo htmlspecialchars($produk['kategori']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" value="<?php echo htmlspecialchars($produk['harga']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" value="<?php echo htmlspecialchars($produk['stok']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
            <div class="card-footer text-right">
                <a href="view_produk.php" class="btn btn-secondary">Kembali ke Daftar Produk</a>
            </div>
        </div>
    </div>
</body>
</html>
