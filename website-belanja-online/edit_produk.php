<?php
session_start();
include('db.php');

if (!isset($_SESSION['seller_id'])) {
    header("Location: login_Penjual.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$sellerId = $_SESSION['seller_id'];

// Ambil data produk dari database
$sql = "SELECT * FROM produk WHERE id = ? AND seller_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id, $sellerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];
    $gambarBaru = $_FILES['gambar']['name'];

    if ($gambarBaru) {
        $gambar_name = time() . '_' . basename($_FILES['gambar']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $gambar_name;

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $gambarFinal = $gambar_name;
        } else {
            $message = "❌ Upload gambar gagal.";
        }
    } else {
        $gambarFinal = $produk['gambar']; // Tetap pakai gambar lama
    }

    if (!$message) {
        $update_sql = "UPDATE produk SET nama_produk = ?, harga = ?, stok = ?, deskripsi = ?, gambar = ? WHERE id = ? AND seller_id = ?";
        $stmt_update = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt_update, "sdisssi", $nama, $harga, $stok, $deskripsi, $gambarFinal, $id, $sellerId);

        if (mysqli_stmt_execute($stmt_update)) {
            header("Location: seller_dasbor.php?update=success");
            exit();
        } else {
            $message = "❌ Gagal memperbarui produk.";
        }
        mysqli_stmt_close($stmt_update);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(270deg, #f5cfd7, #b2c7f1);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .edit-container {
        background: #fff;
        padding: 40px 30px;
        border-radius: 16px;
        max-width: 600px;
        width: 100%;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
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
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    label {
        font-weight: 600;
        color: #444;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea {
        padding: 12px 14px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 15px;
        width: 100%;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    button {
        padding: 12px;
        background: linear-gradient(to right, #667eea, #764ba2);
        color: white;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    button:hover {
        background: linear-gradient(to right, #5a67d8, #6b46c1);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #555;
        text-decoration: none;
        font-weight: 500;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .message {
        padding: 10px 15px;
        background-color: #ffe0e0;
        border: 1px solid #ff9e9e;
        border-radius: 8px;
        color: #a94442;
        margin-bottom: 15px;
        text-align: center;
    }

    .gambar-preview {
        max-width: 100%;
        margin-top: 10px;
        border-radius: 8px;
    }
    </style>
</head>

<body>
    <div class="edit-container">
        <h2>✏️ Edit Produk</h2>

        <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" value="<?= htmlspecialchars($produk['nama_produk']) ?>" required>

            <label>Harga</label>
            <input type="number" step="0.01" name="harga" value="<?= $produk['harga'] ?>" required>

            <label>Stok</label>
            <input type="number" name="stok" value="<?= $produk['stok'] ?>" min="0" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required><?= htmlspecialchars($produk['deskripsi']) ?></textarea>

            <label>Gambar Saat Ini</label>
            <img src="uploads/<?= $produk['gambar'] ?>" alt="Gambar Produk" class="gambar-preview">

            <label>Ganti Gambar (opsional)</label>
            <input type="file" name="gambar" accept="image/*">

            <button type="submit">💾 Simpan Perubahan</button>
        </form>

        <a href="seller_dasbor.php" class="back-link">⬅️ Kembali ke Dashboard</a>
    </div>
</body>

</html>