<?php
include('db.php');

if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM produk WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo "Produk tidak ditemukan.";
    exit;
}

$row = mysqli_fetch_assoc($result);
$gambarArray = explode(',', $row['gambar']); // Asumsi nama gambar dipisahkan koma
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Produk - <?= htmlspecialchars($row['nama_produk']) ?></title>
    <link rel="stylesheet" href="product1.css" />
</head>

<body>
    <div class="top-menu">
        <a href="#">Seller Centre</a>
        <a href="#">Mulai Belajar</a>
        <a href="#">Bukti Kami</a>
    </div>

    <div class="logo">
        <img src="https://via.placeholder.com/100x50?text=LOGO" alt="Logo" width="100px" />
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Cari produk..." />
            <span class="icons">🔍</span>
            <a href="cart.html" class="icon-cart-button">🛒</a>
        </div>
    </div>

    <div class="container">
        <div class="product-detail">
            <div class="product-image">
                <img id="mainImage" src="uploads/<?= htmlspecialchars(trim($gambarArray[0])) ?>"
                    alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                <div class="thumbnail-gallery">
                    <?php foreach ($gambarArray as $gambar): ?>
                    <img src="uploads/<?= htmlspecialchars(trim($gambar)) ?>" onclick="changeImage(this)">
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="product-info">
                <h1 class="product-title"><?= htmlspecialchars($row['nama_produk']) ?></h1>
                <div class="price-box">
                    <?php
                        $hargaDiskon = $row['harga'];
                        $hargaAsli = $hargaDiskon * 1.5; // contoh logika diskon manual
                        $diskon = round((($hargaAsli - $hargaDiskon) / $hargaAsli) * 100);
                    ?>
                    <span class="price-discounted">Rp<?= number_format($hargaDiskon, 0, ',', '.') ?></span>
                    <span class="price-original">Rp<?= number_format($hargaAsli, 0, ',', '.') ?></span>
                    <span class="price-off">-<?= $diskon ?>%</span>
                </div>

                <p class="ic"><?= number_format($row['stok']) ?> stok tersedia</p>
                <div class="rating-review">
                    <div class="stars">⭐ ⭐ ⭐ ⭐ ☆</div>
                    <div class="review-count">4.8 | 321 ulasan</div>
                </div>
                <p id="stok-info">Stok tersedia: <?= $row['stok'] ?></p>

                <div class="variants">
                    <label for="warna">Warna:</label>
                    <select id="warna">
                        <option>Merah</option>
                        <option>Biru</option>
                        <option>Hitam</option>
                    </select>

                    <label for="ukuran">Ukuran:</label>
                    <select id="ukuran">
                        <option>M</option>
                        <option>L</option>
                        <option>XL</option>
                    </select>
                </div>

                <div class="quantity">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" id="jumlah" value="1" min="1" max="<?= $row['stok'] ?>">
                </div>

                <div class="action-buttons">
                    <button class="btn-favorite">♡ Favorit (1,203)</button>
                    <button class="btn-cart">🛒 Masukkan Keranjang</button>
                    <button class="btn-buy-now">Beli Sekarang</button>
                </div>
            </div>
        </div>

        <div class="product-description-section">
            <h2>Deskripsi Produk</h2>
            <p><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
        </div>
    </div>

    <script>
    const stokGlobal = <?= $row['stok'] ?>;
    const productName = "<?= addslashes($row['nama_produk']) ?>";
    const hargaProduk = "Rp<?= number_format($hargaDiskon, 0, ',', '.') ?>";

    document.querySelector(".btn-cart").addEventListener("click", () => {
        const warna = document.getElementById("warna").value;
        const ukuran = document.getElementById("ukuran").value;
        const jumlah = parseInt(document.getElementById("jumlah").value);

        if (jumlah > stokGlobal) {
            alert("Jumlah melebihi stok!");
            return;
        }

        const produk = {
            nama: productName,
            warna,
            ukuran,
            jumlah,
            harga: hargaProduk
        };

        let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
        const index = keranjang.findIndex(item => item.nama === produk.nama && item.warna === warna && item
            .ukuran === ukuran);

        if (index !== -1) keranjang[index].jumlah += jumlah;
        else keranjang.push(produk);

        localStorage.setItem("keranjang", JSON.stringify(keranjang));
        alert("Produk ditambahkan ke keranjang!");
    });

    document.querySelector(".btn-buy-now").addEventListener("click", function(e) {
        e.preventDefault();
        const warna = document.getElementById("warna").value;
        const ukuran = document.getElementById("ukuran").value;
        const jumlah = parseInt(document.getElementById("jumlah").value);

        if (jumlah > stokGlobal) {
            alert("Jumlah melebihi stok!");
            return;
        }

        const produk = [{
            nama: productName,
            warna,
            ukuran,
            jumlah,
            harga: hargaProduk
        }];

        localStorage.setItem("checkoutProduk", JSON.stringify(produk));
        window.location.href = "checkout.html";
    });

    function changeImage(el) {
        document.getElementById("mainImage").src = el.src;
    }
    </script>

</body>

</html>