<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $storeName = trim($_POST["storeName"]);
    $password = $_POST["password"];

    $sql = "SELECT id, password FROM penjual WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $storeName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_bind_result($stmt, $id, $hashedPassword);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['seller_id'] = $id;
                header("Location: seller_dasbor.php");
                exit;
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Akun tidak ditemukan.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Penjual</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap">
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Raleway', sans-serif;
        background: linear-gradient(to bottom, #f7cac9, #92a8d1);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-box {
        background-color: #C4CEE9;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 8px 8px 20px rgba(0, 0, 0, 0.2);
        width: 330px;
        text-align: center;
    }

    .login-box h2 {
        margin-bottom: 20px;
        color: #090e11;
    }

    .logo-container img {
        width: 80px;
        height: 80px;
        margin: 10px auto 20px;
        border-radius: 50%;
        object-fit: cover;
    }

    label {
        display: block;
        text-align: left;
        margin: 10px 0 5px;
        color: #333;
        font-weight: 600;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        background-color: #fff1ee;
        border: none;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #D9D9D9;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }

    .error {
        color: red;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .register-text {
        margin-top: 20px;
        font-size: 13px;
        color: #333;
    }

    .forgot-link {
        font-size: 12px;
        color: #333;
        text-decoration: none;
        display: block;
        margin-top: 5px;
        text-align: center;

    }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Login Penjual</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post" action="">
            <label for="storeName">Nama Toko</label>
            <input type="text" name="storeName" id="storeName" placeholder="Nama Toko" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>

            <button type="submit">Masuk</button>
        </form>
        <a class="forgot-link" href="#">Lupa Password?</a>
    </div>
</body>

</html>