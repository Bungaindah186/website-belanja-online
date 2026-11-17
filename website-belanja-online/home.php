<?php
include('db.php'); 

$sql = "SELECT id, nama_produk, harga, gambar FROM produk ORDER BY created_at DESC ";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="description"
        content="Toko online fashion wanita: gamis, rok, cardigan, dan outfit Korea. Diskon menarik dan ribuan produk terjual. Belanja sekarang!">
    <title>Beranda Produk</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>

    <header>
        <div class="top-menu">
            <a href="#">Seller Centre</a>
            <a href="#">Mulai Belajar</a>
            <a href="#">Bukti Kami</a>
        </div>
        <div class="auth-buttons">
            <a href="signup.php"><button>Sign Up</button></a>
            <a href="login.php"><button>Login</button></a>

        </div>
    </header>
    <div class="logo">

        <img src="https://www.dropbox.com/scl/fi/5aonbed72wuc6ywq884yy/B-s-M-fotor-2025030616620.png?rlkey=065ng2atwqodtp2axns3e33n9&st=c1gmdyu5&dl=1"
            alt="Logo" class="logo" width="100px">

    </div>

    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Cari produk..." />
        <span class="icons">🔍</span>
        <a href="cart.html" class="icon-cart-button">🛒</a>
    </div>
    <nav>
        <a href="#">Terkait</a>
        <a href="#">Terbaru</a>
        <a href="#">Terlaris</a>
        <a href="#">Harga</a>
    </nav>
    <div class="collection">
        <div class="product">
            <a class="product__image" href="product1.html"><img
                    src="https://www.dropbox.com/scl/fi/trbd8fb4hu26rbp141oal/9b017d36-0ff9-45c4-bb43-1560d7eae84c.jpg?rlkey=in285lw3h1r3jve6oxuyi8kdy&st=0xws2p73&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a class="nama" href="product1.html">Gamis Wanita Modern </a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp 90.525
                    <span class="price-off">-15%</span>
                </p>

                <p class="ic">2579 terjual online</p>
            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product2.html"><img
                    src="https://www.dropbox.com/scl/fi/tt3a7mock23elmni5062n/foto2.jpg?rlkey=0gan6d7eq2urrzw2owk81svjq&st=temoyw3y&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product2.html">Ayumi Dress Sailor Gamis Yearbook ala korean style</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp230.000
                    <span class="price-off">-8%</span>
                </p>

                <p class="ic">200 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product3.html"><img
                    src="https://www.dropbox.com/scl/fi/xmc4cgdp6cdlpacn9a02f/foto3.jpg?rlkey=fnrvy7h7fogiu8nj7eb2i78w0&st=ydfki15f&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product3.html">Ayana lace Dress Gamis lebaran</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp191.000
                    <span class="price-off">-32%</span>
                </p>

                <p class="ic">504 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product4.html"><img
                    src="https://www.dropbox.com/scl/fi/cyx8eqlxnr0jd2l5qr3i2/foto4.jpg?rlkey=37r87oon5b6lk5xt35ueev0o0&st=54lp4eqv&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product4.html">Claryn Dress Vintage Lebaran </a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp229.000
                    <span class="price-off">-24%</span>
                </p>
                <p class="ic">259 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product5.html"><img
                    src="https://www.dropbox.com/scl/fi/f4hyidci9m4krem1iitve/foto5.jpg?rlkey=b2gmms5zfxipqsjsn17q9yxkl&st=u9575n6f&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product5.html">Rok blundur midi 7/8 rok bludru Premium mewah wanita dewasa cewek</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp31.900
                    <span class="price-off">-76%</span>
                </p>

                <p class="ic">177.7k terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product6.html"><img
                    src="https://www.dropbox.com/scl/fi/t3a3640xl6bvywh8d8stw/foto6.jpg?rlkey=2cc12cmx2nggiq5df99hbbalh&st=8212dpox&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product6.html">Haseena rok plisket susun maiza skirt Ruffle Anti nerawan</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp53.000
                    <span class="price-off">-46%</span>
                </p>
                <p class="ic">180.8k terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product7.html"><img
                    src="https://www.dropbox.com/scl/fi/jyktd73zrkvqelok3ve14/foto7.jpg?rlkey=gw5jz3fzdmomn0pomd1689jmc&st=ta4bxhqu&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product7.html">Louvee-Flowy Skirt Rok Wanita Rempel A Line Kekinian Style Wanita Panjang
                        Tebal Waist Premium Casual</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp92.500
                    <span class="price-off">-54%</span>
                </p>
                <p class="ic">6538 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product8.html"><img
                    src="https://www.dropbox.com/scl/fi/yr6xth6jzhcobntpf7gc3/foto8.jpg?rlkey=otrx8utwe2thq1148qqeqls1y&st=zr849e0p&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product8.html">Savva skirt Pleated Rok Wanita A Line Maxi Premium Casual Panjang Formal</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp89.500
                    <span class="price-off">-55%</span>
                </p>
                <p class="ic">164 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product9.html"><img
                    src="https://www.dropbox.com/scl/fi/6edkkdtaetutcahknv8h6/foro9.jpg?rlkey=5z5rw25sblxpch82nmx55y1y5&st=mzus7ks5&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product9.html">Korean Cardigan Premium Dark Academia Series </a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp125.000 </p>
                <p class="ic">1182 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product10.html"><img
                    src="https://www.dropbox.com/scl/fi/032rhnbbvy1os2h3c686m/foto10.jpg?rlkey=ccfsxt8uel9ecx1ac101we1aq&st=pmlda3gn&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product10.html">Crewneck Two Tone Oversize/ Sweater Wanita Fleece</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp79.000
                    <span class="price-off">-23%</span>

                <p class="ic">50 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product11.html"><img
                    src="https://www.dropbox.com/scl/fi/2e5gzq87zbzouyzyd3ut1/foro11.jpg?rlkey=45amq2dqqrfdn3bwxh9k9o30y&st=6aq577ge&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product11.html">Korean Coat By Aruna Outfit</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp60.900
                    <span class="price-off">-3%</span>

                <p class="ic">1457 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product12.html"><img
                    src="https://www.dropbox.com/scl/fi/fhqrtiy75s9944hmzls2m/foro12.jpg?rlkey=epmn267h0kqjj1ub4mxn6zghu&st=7p3g7rpr&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product12.html">Knit Bear By Hoodiebear X Aruna</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp99.000
                    <span class="price-off">-23%</span>

                <p class="ic">100 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product13.html"><img
                    src="https://www.dropbox.com/scl/fi/d3y93um1aogj1yksqnsgq/foto13.jpg?rlkey=g3rogukpdjm69cs97czvhrfyb&st=wf32p671&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product13.html">Fluffy Bear Jacket By Hoodiebear</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp160.000
                    <span class="price-off">-20%</span>
                </p>
                <p class="ic">86 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product14.html"><img
                    src="https://www.dropbox.com/scl/fi/njy0eihm0d76sbgwfkc4f/foto14.jpg?rlkey=ztxdxxr7gbc8f4m6uykltfzr0&st=ltfg585w&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product14.html">Comfy Cardy By Arunaoutfit</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp78.750
                    <span class="price-off">-17%</span>
                </p>

                <p class="ic">1617 terjual online</p>

            </div>
        </div>
        <div class="product">
            <a class="product__image" href="product15.html"><img
                    src="https://www.dropbox.com/scl/fi/18gzztm3h0zuipda2ihp6/foto15.jpg?rlkey=mejvcmnt7d19nv8eddnj2gdta&st=vkt5bz2j&dl=1"
                    alt="" width="300px"></a>
            <div class="product__name">
                <p>
                    <a href="product15.html">Batwing Tunik Abaya Versi Sachet By Arunaoutfit</a>
                </p>
            </div>
            <div class="product__price">
                <p>Rp99.000
                    <span class="price-off">-17%</span>
                </p>
                <p class="ic">150 terjual online</p>

            </div>
        </div>
        <div class="collection">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product">
                <a class="product__image" href="product_detail.php">
                    <img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>"
                        alt="<?php echo htmlspecialchars($row['nama_produk']); ?>">
                </a>
                <div class="product__name">
                    <p>
                        <a href="product_detail.php">
                            <?php echo htmlspecialchars($row['nama_produk']); ?>
                        </a>
                    </p>
                </div>
                <div class="product__price">
                    <p>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                    <p class="ic">Baru ditambahkan</p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <script>
    const searchInput = document.getElementById('searchInput');
    const products = document.querySelectorAll('.product');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();

        products.forEach(product => {
            const productName = product.querySelector('.product__name a').textContent.toLowerCase();
            if (productName.includes(searchTerm)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    });
    </script>
</body>

</html>