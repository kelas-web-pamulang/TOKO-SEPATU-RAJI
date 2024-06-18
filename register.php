<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        input[type="text"], input[type="email"], input[type="password"] {
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
        .login {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" name="register" value="Register">
        </form>

        <div class="login">
            Sudah memiliki akun? <a href="login.php">Coba Login !!!</a>
        </div>

        <?php
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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
            try {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                // Check if email already exists
                $sql_check_email = "SELECT id FROM users WHERE email = :email";
                $stmt_check_email = $pdo->prepare($sql_check_email);
                $stmt_check_email->execute(['email' => $email]);

                // Check if username already exists
                $sql_check_username = "SELECT id FROM users WHERE username = :username";
                $stmt_check_username = $pdo->prepare($sql_check_username);
                $stmt_check_username->execute(['username' => $username]);

                if ($stmt_check_email->rowCount() > 0) {
                    echo "<p style='color: red;'>Email sudah digunakan. Silakan gunakan email lain.</p>";
                } elseif ($stmt_check_username->rowCount() > 0) {
                    echo "<p style='color: red;'>Username sudah digunakan. Silakan pilih username lain.</p>";
                } else {
                    // Insert new user data
                    $sql_insert_user = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
                    $stmt_insert_user = $pdo->prepare($sql_insert_user);
                    $stmt_insert_user->execute(['username' => $username, 'email' => $email, 'password' => $password]);

                    echo "<p style='color: green;'>Selamat Registrasi Anda Berhasil.</p>";
                }
            } catch (Exception $e) {
                SentrySdk::captureException($e);
                logError("Error during registration: " . $e->getMessage());
                echo "<p style='color: red;'>Terjadi kesalahan saat registrasi. Silakan coba lagi nanti.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
