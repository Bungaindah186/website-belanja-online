<?php
session_start();
include('db.php');

if (!isset($_SESSION['seller_id'])) {
    header("Location: login_Penjual.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$sellerId = $_SESSION['seller_id'];

// Hapus gambar dari server dulu
$get_image = "SELECT gambar FROM produk WHERE id = ? AND seller_id = ?";
$stmt_img = mysqli_prepare($conn, $get_image);
mysqli_stmt_bind_param($stmt_img, "ii", $id, $sellerId);
mysqli_stmt_execute($stmt_img);
$result_img = mysqli_stmt_get_result($stmt_img);
if ($row = mysqli_fetch_assoc($result_img)) {
    $gambar_path = "uploads/" . $row['gambar'];
    if (file_exists($gambar_path)) {
        unlink($gambar_path);
    }
}
mysqli_stmt_close($stmt_img);

// Hapus produk dari database
$sql = "DELETE FROM produk WHERE id = ? AND seller_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id, $sellerId);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: seller_dasbor.php");
exit();