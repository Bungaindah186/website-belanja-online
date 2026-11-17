<?php
session_start();
include('db.php');

if (!isset($_SESSION['seller_id'])) {
    header("Location: login_Penjual.php");
    exit();
}

$sellerId = $_SESSION['seller_id'];
$sql = "SELECT username, email FROM penjual WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $sellerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $storeName = htmlspecialchars($row['username']);
    $email = htmlspecialchars($row['email']);
} else {
    echo "Data tidak ditemukan.";
    exit();
}
mysqli_stmt_close($stmt);

// Ambil daftar produk
$sql_produk = "SELECT id, nama_produk, harga, gambar, created_at FROM produk WHERE seller_id = ? ORDER BY created_at DESC";
$stmt_produk = mysqli_prepare($conn, $sql_produk);
mysqli_stmt_bind_param($stmt_produk, "i", $sellerId);
mysqli_stmt_execute($stmt_produk);
$produk_result = mysqli_stmt_get_result($stmt_produk);

$produk_list = [];
while ($produk = mysqli_fetch_assoc($produk_result)) {
    $produk_list[] = $produk;
}
mysqli_stmt_close($stmt_produk);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Penjual</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(270deg, #f5cfd7, #b2c7f1);
        min-height: 100vh;
        padding: 40px 20px;
    }

    .dashboard {
        background-color: #fff;
        max-width: 1100px;
        margin: auto;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .info p {
        margin: 4px 0;
        color: #444;
    }

    .actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin: 25px 0;
    }

    .actions a {
        padding: 10px 18px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 8px;
        background-color: #ffece3;
        color: #333;
        border: 1px solid #f1cfc0;
        transition: all 0.25s ease;
    }

    .actions a:hover {
        background-color: #ffdbc8;
        transform: scale(1.03);
    }

    .produk-section h2 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
    }

    .produk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    .produk-card {
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s;
    }

    .produk-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .produk-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .produk-card h3 {
        font-size: 16px;
        margin: 10px 12px 5px;
        color: #222;
        font-weight: 600;
    }

    .harga-produk {
        font-size: 15px;
        color: #e52c2c;
        margin: 0 12px;
        font-weight: 600;
    }

    .produk-card small {
        display: block;
        margin: 5px 12px;
        font-size: 12px;
        color: #777;
    }

    .produk-actions {
        margin: 10px 12px 15px;
        display: flex;
        justify-content: space-between;
    }

    .btn-edit,
    .btn-delete {
        padding: 6px 10px;
        font-size: 13px;
        text-decoration: none;
        border-radius: 6px;
        transition: background-color 0.2s ease;
    }

    .btn-edit {
        background-color: #d7f5e9;
        color: #117a53;
        border: 1px solid #c0f0dc;
    }

    .btn-edit:hover {
        background-color: #b3ecd5;
    }

    .btn-delete {
        background-color: #ffe0e0;
        color: #a33a3a;
        border: 1px solid #f6c1c1;
    }

    .btn-delete:hover {
        background-color: #ffc5c5;
    }

    .no-produk {
        font-style: italic;
        color: #888;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .produk-card img {
            height: 150px;
        }

        .actions {
            flex-direction: column;
        }
    }
    </style>
</head>

<body>
    <div class="dashboard">
        <h1>Selamat Datang, <?= $storeName; ?> 👋</h1>
        <div class="info">
            <p><strong>Email:</strong> <?= $email; ?></p>
            <p>Kelola produkmu dengan mudah di bawah ini.</p>
        </div>

        <div class="actions">
            <a href="upload_produk.php">➕ Tambah Produk</a>
            <a href="edit_profil.php">⚙️ Edit Profil</a>
            <a href="laporan_penjual.php">📊 Laporan Penjualan</a>
            <a href="logout.php">🚪 Logout</a>
        </div>

        <div class="produk-section">
            <h2>📦 Daftar Produk</h2>
            <?php if (count($produk_list) > 0): ?>
            <div class="produk-grid">
                <?php foreach ($produk_list as $produk): ?>
                <div class="produk-card">
                    <img src="uploads/<?= htmlspecialchars($produk['gambar']); ?>" alt="Gambar Produk">
                    <h3><?= htmlspecialchars($produk['nama_produk']); ?></h3>
                    <p class="harga-produk">Rp <?= number_format($produk['harga'], 2, ',', '.'); ?></p>
                    <small>📅 <?= date('d M Y, H:i', strtotime($produk['created_at'])); ?></small>
                    <div class="produk-actions">
                        <a href="edit_produk.php?id=<?= $produk['id']; ?>" class="btn-edit">✏️ Edit</a>
                        <a href="hapus_produk.php?id=<?= $produk['id']; ?>" class="btn-delete"
                            onclick="return confirm('Yakin ingin menghapus produk ini?')">🗑️ Hapus</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="no-produk">Belum ada produk yang diunggah.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>