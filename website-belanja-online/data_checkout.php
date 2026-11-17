<?php
include('db.php'); // file koneksi database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die(json_encode(['status' => 'error', 'message' => 'Koneksi database gagal.']));
}

// Terima data JSON dari JavaScript
$data = json_decode(file_get_contents("php://input"), true);

// Validasi
if (!$data || !isset($data['produk'], $data['total'], $data['alamat'], $data['metode'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap.']);
    exit;
}

// Sanitasi input
$alamat = mysqli_real_escape_string($conn, $data['alamat']);
$metode = mysqli_real_escape_string($conn, $data['metode']);
$total = intval($data['total']);

// Simpan ke tabel transaksi
$sql = "INSERT INTO transaksi (alamat, metode_pembayaran, total) VALUES ('$alamat', '$metode', $total)";
if (mysqli_query($conn, $sql)) {
    $transaksi_id = mysqli_insert_id($conn);

    // Simpan detail produk
    foreach ($data['produk'] as $item) {
        $nama = mysqli_real_escape_string($conn, $item['nama']);
        $harga = intval(preg_replace('/[^\d]/', '', $item['harga']));
        $jumlah = intval($item['jumlah']);
        $subtotal = $harga * $jumlah;

        $sqlDetail = "INSERT INTO detail_transaksi (transaksi_id, nama_produk, harga, jumlah, subtotal)
                      VALUES ($transaksi_id, '$nama', $harga, $jumlah, $subtotal)";
        mysqli_query($conn, $sqlDetail);
    }

    echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil disimpan.']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan transaksi.']);
}

mysqli_close($conn);
?>