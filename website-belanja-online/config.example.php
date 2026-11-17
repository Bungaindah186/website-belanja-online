<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bunga_store";

$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);

if (!$conn) {
    die("Koneksi database gagal.");
}