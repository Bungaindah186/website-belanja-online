<?php
include('db.php'); // Koneksi ke database

// Fungsi untuk menampilkan halaman HTML dengan styling
function showMessage($title, $message, $logoPath = '', $isSuccess = true) {
    $style = $isSuccess ? "color: green;" : "color: red;";
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Hasil Pendaftaran Penjual</title>
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: #f7f7f7;
                padding: 40px;
                text-align: center;
            }
            .container {
                background-color: white;
                max-width: 600px;
                margin: auto;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            h2 {
                margin-bottom: 10px;
            }
            p {
                font-size: 16px;
                margin-top: 10px;
            }
            .logo {
                margin-top: 20px;
            }
            a {
                color: #007BFF;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2 style="$style">$title</h2>
            <p>$message</p>
HTML;

    if ($logoPath) {
        echo "<div class='logo'><img src='$logoPath' alt='Logo Toko' style='max-width:200px; margin-top:20px;'></div>";
    }

    echo <<<HTML
            <p><a href="login_penjual.php">➤ Masuk ke akun Anda</a></p>
            <p><a href="sellerregister.php">← Kembali ke formulir pendaftaran</a></p>
        </div>
    </body>
    </html>
HTML;
}

// Proses saat form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $storeName   = htmlspecialchars(trim($_POST["storeName"]));
    $email       = htmlspecialchars(trim($_POST["email"]));
    $phone       = htmlspecialchars(trim($_POST["phone"]));
    $description = htmlspecialchars(trim($_POST["description"]));
    $password    = $_POST["password"];
    $passwordConfirm = $_POST["password_confirm"];

    // Validasi
    if ($password !== $passwordConfirm) {
        showMessage("Gagal Mendaftar", "Password dan konfirmasi password tidak cocok.", '', false);
        exit;
    }
    if (strlen($password) < 6) {
        showMessage("Gagal Mendaftar", "Password minimal harus 6 karakter.", '', false);
        exit;
    }

    // Upload logo
    $uploadDirectory = "uploads/";
    $logoPath = "";

    if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] === UPLOAD_ERR_OK) {
        $fileTmp  = $_FILES["logo"]["tmp_name"];
        $fileName = basename($_FILES["logo"]["name"]);
        $safeName = time() . "-" . preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName);
        $logoPath = $uploadDirectory . $safeName;

        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        move_uploaded_file($fileTmp, $logoPath);
    }
// menyimpan data ke txt
    $entry = "Nama Toko: $storeName\nEmail: $email\nNo. HP: $phone\nDeskripsi: $description\nLogo: $logoPath\n\n";
    file_put_contents("data-penjual.txt", $entry, FILE_APPEND);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO penjual (username, password, email) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $storeName, $hashedPassword, $email);

    if (mysqli_stmt_execute($stmt)) {
        showMessage(
            "Pendaftaran Berhasil",
            "Terima kasih telah mendaftar, <strong>$storeName</strong>. Kami akan menghubungi Anda melalui email: <strong>$email</strong>.",
            $logoPath,
            true
        );
    } else {
        showMessage("Gagal Mendaftar", "Terjadi kesalahan saat menyimpan ke database: " . htmlspecialchars(mysqli_error($conn)), '', false);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    showMessage("Akses Tidak Valid", "Formulir belum dikirim.", '', false);
}
?>