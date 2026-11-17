<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link rel="stylesheet" href="sigstyles.css" />
</head>

<body>
    <div class="container">
        <div class="signup-box">
            <h2>Sign UP</h2>
            <div class="logo">
                <img src="https://www.dropbox.com/scl/fi/5aonbed72wuc6ywq884yy/B-s-M-fotor-2025030616620.png?rlkey=065ng2atwqodtp2axns3e33n9&st=b94prypj&dl=1"
                    alt="Logo" />
            </div>
            <form action="prosesSignup.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required />

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required />

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required />

                <button type="submit">Sign Up</button>
            </form>
            <p class="login-link">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
</body>

</html>