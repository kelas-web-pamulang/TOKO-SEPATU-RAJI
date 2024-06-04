<?php
require 'config.php';

// Inisialisasi array pelanggan dengan nilai default
$pelanggan = ['id' => '', 'nama_pelanggan' => '', 'alamat' => '', 'telepon' => ''];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM pelanggan WHERE id = ?");
    $stmt->execute([$id]);
    $pelanggan = $stmt->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];

    if (!empty($nama_pelanggan)) {
        $stmt = $pdo->prepare("UPDATE pelanggan SET nama_pelanggan = ?, alamat = ?, telepon = ? WHERE id = ?");
        $stmt->execute([$nama_pelanggan, $alamat, $telepon, $id]);

        echo "Pelanggan berhasil diperbarui!";
    } else {
        echo "Nama pelanggan harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pelanggan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        form {
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
        input[type="text"] {
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
        .btn-back {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Pelanggan</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($pelanggan['id']); ?>">
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan:</label>
                <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" value="<?php echo htmlspecialchars($pelanggan['nama_pelanggan']); ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" class="form-control" value="<?php echo htmlspecialchars($pelanggan['alamat']); ?>">
            </div>
            <div class="form-group">
                <label for="telepon">Telepon:</label>
                <input type="text" id="telepon" name="telepon" class="form-control" value="<?php echo htmlspecialchars($pelanggan['telepon']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Perbarui Pelanggan</button>
            <a href="view_pelanggan.php" class="btn btn-secondary btn-back">Kembali ke Daftar Pelanggan</a>
        </form>
    </div>
</body>
</html>
