<html>

<head>
    <title>Form Komentar</title>
</head>

<body>
    <p><strong class="isi">Isikan Komentar Anda
        </strong>
    </p>
    <form id="form1" name="form1" method="post" action="M4C2.php">
        <p>
            <label for="nama"></label> Nama :
            <input name="nama" type="text" id="nama" size="40" />
        </p>
        <p>Komentar
            <label for="komentar"></label>
            <textarea name="komentar" cols="50" rows="6" id="komentar"></textarea>
        </p>
        <p>
            <input type="submit" name="proses" id="proses" value="PROSES" />
        </p>
    </form>
</body>

</html>