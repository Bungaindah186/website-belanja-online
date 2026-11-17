<?php
session_start();
include('db.php'); // koneksi ke database

// Cek apakah user sudah login
if (!isset($_SESSION['seller_id'])) {
    echo "Anda belum login sebagai penjual.";
    exit;
}

$seller_id = intval($_SESSION['seller_id']); // Ambil ID dari session

// Query laporan penjualan berdasarkan seller_id
$sql = "
SELECT 
    p.nama_produk,
    SUM(dt.jumlah) AS total_terjual,
    SUM(dt.subtotal) AS total_pendapatan
FROM produk p
JOIN detail_transaksi dt ON dt.nama_produk = p.nama_produk
WHERE p.seller_id = ?
GROUP BY p.nama_produk
ORDER BY total_terjual DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();

$total_keseluruhan = 0;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        padding: 40px;
        background: #f9f9f9;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
        font-size: 15px;
    }

    th {
        background-color: #f3f3f3;
        font-weight: bold;
    }

    tfoot th {
        background-color: #fafafa;
        font-size: 16px;
        font-weight: 600;
    }
    </style>
</head>

<body>

    <h2>📊 Laporan Penjualan Produk</h2>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Total Terjual</th>
                <th>Total Pendapatan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <?php $total_keseluruhan += $row['total_pendapatan']; ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                <td><?= $row['total_terjual'] ?></td>
                <td><?= number_format($row['total_pendapatan'], 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
            <?php else: ?>
            <tr>
                <td colspan="3">Tidak ada data penjualan ditemukan.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total Pendapatan Keseluruhan</th>
                <th>Rp<?= number_format($total_keseluruhan, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>

</body>

</html>