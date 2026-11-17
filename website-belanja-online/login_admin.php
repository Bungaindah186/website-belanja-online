<?php
session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dasboar_admin.php");
    exit();
}

// Memuat konfigurasi admin lokal
$configFile = __DIR__ . '/admin_config.local.php';

if (!file_exists($configFile)) {
    die("Konfigurasi admin belum tersedia.");
}

$adminConfig = require $configFile;

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (
        isset($adminConfig['username'], $adminConfig['password_hash']) &&
        hash_equals($adminConfig['username'], $username) &&
        password_verify($password, $adminConfig['password_hash'])
    ) {
        session_regenerate_id(true);

        $_SESSION['admin_logged_in'] = true;

        header("Location: dasboar_admin.php");
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(270deg, #f5cfd7, #b2c7f1);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }

    .login-box {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        width: 350px;
        max-width: 90%;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
    }

    input {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    button {
        padding: 12px;
        width: 100%;
        background: linear-gradient(to right, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.9;
    }

    .error {
        color: red;
        margin-top: 10px;
    }
    </style>
</head>

<body>

    <div class="login-box">
        <h2>Login Admin</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username Admin" autocomplete="username" required>

            <input type="password" name="password" placeholder="Password" autocomplete="current-password" required>

            <button type="submit">Login</button>

            <?php if ($error): ?>
            <p class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>
            <?php endif; ?>
        </form>
    </div>

</body>

</html>