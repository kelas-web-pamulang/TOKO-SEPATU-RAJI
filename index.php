<!DOCTYPE html>
<html>
<head>
    <title>TOKO RAJI</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-top: 20px;
        }
        .nav-link {
            font-size: 18px;
        }
        .jumbotron {
            background-color: #007bff;
            color: white;
            position: relative;
            height: 300px; /* Sesuaikan tinggi jumbotron */
        }
        .jumbotron img {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            max-height: 300px; /* Sesuaikan tinggi maksimum gambar */
            width: auto;
        }
        .jumbotron h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: 0;
            z-index: 2;
        }
        .card-deck {
            margin-top: 20px;
        }
        .welcome-message {
            text-align: center;
            margin-top: 20px; /* Sesuaikan jarak dari jumbotron */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="jumbotron text-center mt-5">
            <img src="images/raji.png" alt="Logo Toko RAJ">
        </div>
        <div class="welcome-message">
            <h1>Selamat Datang di Toko Rafi & Aji</h1>
        </div>
        <div class="card-deck">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Produk</h5>
                    <p class="card-text">Kelola data produk.</p>
                    <a href="add_produk.php" class="btn btn-primary">Tambah Produk</a>
                    <a href="view_produk.php" class="btn btn-secondary">Lihat Produk</a>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Pelanggan</h5>
                    <p class="card-text">Kelola data pelanggan.</p>
                    <a href="add_pelanggan.php" class="btn btn-primary">Tambah Pelanggan</a>
                    <a href="view_pelanggan.php" class="btn btn-secondary">Lihat Pelanggan</a>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Transaksi</h5>
                    <p class="card-text">Kelola data transaksi.</p>
                    <a href="add_transaksi.php" class="btn btn-primary">Tambah Transaksi</a>
                    <a href="view_transaksi.php" class="btn btn-secondary">Lihat Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
