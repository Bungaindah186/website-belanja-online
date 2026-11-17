<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="lostyles.css">
</head>

<body>
    <div class="login-box">
        <h2>Login</h2>
        <div class="logo-container">
            <img src="https://www.dropbox.com/scl/fi/5aonbed72wuc6ywq884yy/B-s-M-fotor-2025030616620.png?rlkey=065ng2atwqodtp2axns3e33n9&st=b94prypj&dl=1"
                alt="Logo">
        </div>
        <form action="prosesLogin.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required>

            <div class="password-container">
                <label for="password">Password</label>
                <a href="#" class="forgot-link">Lupa password?</a>
            </div>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <button type="submit">Login</button>
        </form>
        <p class="register-text">Belum punya akun? <a href="signup.php">Daftar di sini</a></p>
    </div>
</body>

</html>