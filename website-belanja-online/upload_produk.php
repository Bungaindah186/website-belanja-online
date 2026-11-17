<?php
session_start();
include('db.php');

if (!isset($_SESSION['seller_id'])) {
    header("Location: login_Penjual.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = trim($_POST['nama_produk']);
    $harga = floatval($_POST['harga']);
    $stok = intval($_POST['stok']);
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = $_FILES['gambar'];
    $seller_id = $_SESSION['seller_id'];

    if ($nama_produk && $harga && $stok >= 0 && $deskripsi && $gambar['name']) {
        $gambar_name = time() . '_' . basename($gambar['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $gambar_name;

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($gambar['tmp_name'], $target_file)) {
            $sql = "INSERT INTO produk (nama_produk, harga, stok, deskripsi, gambar, seller_id)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sdissi", $nama_produk, $harga, $stok, $deskripsi, $gambar_name, $seller_id);

            if (mysqli_stmt_execute($stmt)) {
                $message = "✅ Produk berhasil ditambahkan!";
            } else {
                $message = "❌ Gagal menyimpan ke database.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "❌ Upload gambar gagal.";
        }
    } else {
        $message = "⚠️ Semua field wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Upload Produk</title>
    <link rel="stylesheet" href="uploud_produk.css">
</head>

<body>
    <div class="form-container">
        <h2>🛒 Tambahkan Produk Baru</h2>
        <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <label>Nama Produk:</label>
            <input type="text" name="nama_produk" required>

            <label>Harga:</label>
            <input type="number" step="0.01" name="harga" required>

            <label>Stok Produk:</label>
            <input type="number" name="stok" min="0" required>

            <label>Deskripsi:</label>
            <textarea name="deskripsi" required></textarea>

            <label>Gambar Produk:</label>
            <input type="file" name="gambar" accept="image/*" required>

            <button type="submit">➕ Tambah Produk</button>
        </form>
        <a href="seller_dasbor.php" class="back-btn">⬅️ Kembali ke Dashboard</a>
    </div>
</body>

</html>