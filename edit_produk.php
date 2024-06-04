<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->execute([$id]);
    $produk = $stmt->fetch();
} else {
    $produk = ['id' => '', 'nama_produk' => '', 'kategori' => '', 'harga' => '', 'stok' => '']; // Inisialisasi array produk dengan nilai default
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

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
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Edit Produk</h1>
        <form method="post" class="mt-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($produk['id']); ?>">
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
        <br>
        <a href="view_produk.php" class="btn btn-secondary">Kembali ke Daftar Produk</a>
    </div>
</body>
</html>
