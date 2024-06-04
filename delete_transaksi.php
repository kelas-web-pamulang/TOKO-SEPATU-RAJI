<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM transaksi WHERE id = ?");
    $stmt->execute([$id]);

    echo "Transaksi berhasil dihapus!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hapus Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <a href="view_transaksi.php" class="btn btn-secondary mt-5">Kembali ke Daftar Transaksi</a>
    </div>
</body>
</html>
