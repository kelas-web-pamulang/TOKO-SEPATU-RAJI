<?php
session_start();
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

// Function to log errors
function logError($message) {
    error_log($message . "\n", 3, "error.log");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    try {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT id, password FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;

                header("Location: index.php");
                exit();
            } else {
                echo "<p style='color: red;'>Password salah.</p>";
            }
        } else {
            echo "<p style='color: red;'>Username tidak ditemukan.</p>";
        }
    } catch (Exception $e) {
        SentrySdk::captureException($e);
        logError("Error during login: " . $e->getMessage());
        echo "<p style='color: red;'>Terjadi kesalahan saat login. Silakan coba lagi nanti.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Heula Atuh</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/bgsepatu1.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #f4f4f4; 
            padding-top: 50px;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .register {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>LOGIN</h2>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" name="login" value="Login">
        </form>

        <div class="register">
            Belum punya akun? <a href="register.php">Daftar disini</a>
        </div>
    </div>
</body>
</html>
