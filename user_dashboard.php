<?php
session_start();
require 'functions.php';
if (!isset($_SESSION["login"]) || $_SESSION["level"] !== "user") {
    header("location: login.php");
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Toko Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <h3 class="judul">Selamat Datang, <?= $_SESSION['login']; ?></h3>
        <div class="teks">
            <p>Semoga harimu selalu Senin, salam dingin dari Admin <br>-_-<br><br>dan <b>jangan belanja di sini!</b> <br>Nanti Admin kaya</p>
            <p>Terimakasih</p>
            <a href="logout.php" class="btn">Logout</a>
            <a href="ganti_pass.php" target="_blank" class="btn">Ganti Password</a>
        </div>
    </div>
</body>

</html>