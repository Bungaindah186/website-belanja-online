Prokomentar.php
<html>
<head><title>Belajar Form</title>
</head>
<body>
<p><strong class="isi">Isikan Komentar Anda </strong></p>
<?php extract($_POST);
echo "Selamat Datang $nama <br> Terima Kasih atas Komentar anda
$komentar";

?>
</body>
</html>
