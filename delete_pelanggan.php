<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM pelanggan WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: view_pelanggan.php");
    exit;
}
?>
