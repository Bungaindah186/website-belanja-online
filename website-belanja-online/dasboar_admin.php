<?php
session_start();
include('db.php'); // koneksi database

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login_admin.php");
    exit();
}

// Statistik
$total_produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk"))['total'];
$total_penjual = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM penjual"))['total'];

// Total Pendapatan dihitung dari detail_transaksi
$pendapatanQuery = "SELECT SUM(harga * jumlah) AS total FROM detail_transaksi";
$pendapatanResult = mysqli_query($conn, $pendapatanQuery);
$pendapatanRow = mysqli_fetch_assoc($pendapatanResult);
$total_pendapatan = $pendapatanRow['total'] ?? 0;

// Ambil data produk dan penjual
$produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY created_at DESC");
$penjual = mysqli_query($conn, "SELECT * FROM penjual ORDER BY id DESC");

// Ambil data transaksi gabungan
$transaksi = mysqli_query($conn, "
    SELECT 
        dt.id AS id_detail,
        dt.transaksi_id,
        dt.nama_produk,
        dt.harga,
        dt.jumlah,
        dt.subtotal,
        t.tanggal
    FROM detail_transaksi dt
    JOIN transaksi t ON dt.transaksi_id = t.id
    ORDER BY dt.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background: #f4f6f9;
        padding: 40px;
    }

    h1,
    h2 {
        text-align: center;
        color: #333;
    }

    .stats {
        display: flex;
        gap: 20px;
        margin: 30px auto;
        justify-content: center;
        flex-wrap: wrap;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        width: 250px;
        text-align: center;
    }

    .card h2 {
        margin-bottom: 10px;
        font-size: 20px;
        color: #555;
    }

    .card p {
        font-size: 26px;
        font-weight: bold;
        color: #111;
    }

    table {
        width: 100%;
        background: white;
        border-collapse: collapse;
        margin: 40px 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    th {
        background: #667eea;
        color: white;
    }

    tr:hover {
        background: #f1f1f1;
    }

    .logout {
        display: block;
        text-align: center;
        margin-top: 30px;
    }

    .logout a {
        color: #dc3545;
        text-decoration: none;
        font-weight: bold;
    }

    .logout a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>

    <h1>📊 Dashboard Admin</h1>

    <div class="stats">
        <div class="card">
            <h2>Total Produk</h2>
            <p><?php echo $total_produk; ?></p>
        </div>
        <div class="card">
            <h2>Total Penjual</h2>
            <p><?php echo $total_penjual; ?></p>
        </div>
        <div class="card">
            <h2>Total Pendapatan</h2>
            <p>Rp<?php echo number_format($total_pendapatan, 0, ',', '.'); ?></p>
        </div>
    </div>

    <h2>🛍️ Daftar Produk</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>ID Penjual</th>
            <th>Tanggal</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($produk)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>
            <td>Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
            <td><?php echo $row['seller_id']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>👤 Daftar Penjual</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Toko</th>
            <th>Email</th>
        </tr>
        <?php while ($penjual_row = mysqli_fetch_assoc($penjual)): ?>
        <tr>
            <td><?php echo $penjual_row['id']; ?></td>
            <td><?php echo htmlspecialchars($penjual_row['username']); ?></td>
            <td><?php echo htmlspecialchars($penjual_row['email']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>🧾 Laporan Transaksi Penjualan</h2>
    <table>
        <tr>
            <th>ID Transaksi</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($transaksi)): ?>
        <tr>
            <td><?php echo $row['transaksi_id']; ?></td>
            <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>
            <td><?php echo $row['jumlah']; ?></td>
            <td>Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
            <td>Rp<?php echo number_format($row['subtotal'], 0, ',', '.'); ?></td>
            <td><?php echo $row['tanggal']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="logout">
        <a href="logout_admin.php">🚪 Logout</a>
    </div>

</body>

</html>