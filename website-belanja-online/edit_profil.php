<?php
session_start();
include('db.php');

if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

$sellerId = $_SESSION['seller_id'];
$message = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE penjual SET email = ?, password = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $email, $hashed, $sellerId);
    } else {
        $sql = "UPDATE penjual SET email = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $email, $sellerId);
    }

    if (mysqli_stmt_execute($stmt)) {
        $message = "✅ Profil berhasil diperbarui.";
    } else {
        $error = "❌ Gagal memperbarui profil.";
    }

    mysqli_stmt_close($stmt);
}

$sql = "SELECT username, email FROM penjual WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $sellerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(270deg, #f5cfd7, #b2c7f1);
        margin: 0;
        padding: 40px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .profile-container {
        background-color: #fff;
        border-radius: 16px;
        padding: 40px 30px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    h2 {
        text-align: center;
        font-size: 26px;
        margin-bottom: 25px;
        font-weight: 700;
        color: #333;
    }

    .message {
        text-align: center;
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 8px;
        font-weight: 600;
    }

    .success {
        background-color: #e6ffed;
        color: #2f855a;
        border: 1px solid #c6f6d5;
    }

    .error {
        background-color: #ffe0e0;
        color: #a94442;
        border: 1px solid #ff9e9e;
    }

    label {
        font-weight: 600;
        display: block;
        margin-top: 15px;
        color: #444;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 12px 14px;
        margin-top: 6px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 15px;
        outline: none;
        transition: border-color 0.2s;
    }

    input:focus {
        border-color: #667eea;
    }

    .readonly-field {
        background-color: #f4f4f4;
        padding: 12px 14px;
        border-radius: 10px;
        margin-bottom: 12px;
        font-weight: 600;
    }

    button {
        margin-top: 20px;
        width: 100%;
        background: linear-gradient(to right, #667eea, #764ba2);
        color: white;
        padding: 12px;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: linear-gradient(to right, #5a67d8, #6b46c1);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #555;
        font-weight: 500;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="profile-container">
        <h2>⚙️ Edit Profil</h2>

        <?php if (!empty($message)): ?>
        <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
        <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <label>Nama Toko</label>
            <div class="readonly-field"><?php echo htmlspecialchars($data['username']); ?></div>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>"
                required>

            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password"
                placeholder="Kosongkan jika tidak ingin mengubah password">

            <button type="submit">💾 Simpan Perubahan</button>
        </form>

        <a class="back-link" href="seller_dasbor.php">⬅️ Kembali ke Dashboard</a>
    </div>
</body>

</html>