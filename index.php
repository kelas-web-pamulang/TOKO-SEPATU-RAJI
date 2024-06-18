<?php

require_once 'vendor/autoload.php';

\Sentry\init([
  'dsn' => 'https://2dfc0fa4bce6fe2c740b458a3b8d7e97@o4507451047477248.ingest.us.sentry.io/4507451380858880',
  // Specify a fixed sample rate
  'traces_sample_rate' => 1.0,
  // Set a sampling rate for profiling - this is relative to traces_sample_rate
  'profiles_sample_rate' => 1.0,
]);

session_start();

ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

try {
    // Contoh kode yang mungkin menimbulkan error
    // Misalnya, akses array yang tidak ada
    //$array = [];
    //echo $array['key'];
} catch (Exception $e) {
    Sentry\captureException($e);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>TOKO RAJI</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding-top: 50px;
        }
        .container {
            position: relative;
            margin-bottom: 50px;
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
            height: 300px;
            margin-top: 20px; 
        }
        .jumbotron img {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            max-height: 300px; 
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
            margin-bottom: 5px; 
        }
        .user-info {
            text-align: right;
            margin-top: 10px;
        }
        .logout-btn {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">
            <span>Spadaaaaaaaaa, <?php echo htmlspecialchars($username); ?>!</span>
            <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
        </div>

        <div class="jumbotron text-center mt-5">
            <img src="images/raji.png" alt="Logo Toko RAJ">
        </div>
        <div class="welcome-message">
            <h1>Selamat Datang di Toko Rafi & Aji</h1>
        </div>
        <div class="card-deck">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Management Produk dan Pelanggan</h5>
                    <p class="card-text">Kelola data produk dan pelanggan.</p>
                    <a href="produk.php?add" class="btn btn-primary">Masuk kedalam System</a>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Management Transaksi</h5>
                    <p class="card-text">Kelola data transaksi.</p>
                    <a href="transaksi.php?add" class="btn btn-primary">System Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
