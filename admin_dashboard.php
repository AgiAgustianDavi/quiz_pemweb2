<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["level"] !== "admin") {
    header("location: login.php");
    exit;
}
require 'functions.php';

$table = query("select * from users order by username ASC");

// jika tombol cari di klik
if (isset($_POST["cari"])) {
    $table = search($_POST["keyword"]);
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
        <h3 class="judul">Selamat Datang, <?= $_SESSION['login'];  ?></h3>
        <div class="teks">
            <p>Semoga hari selalu Minggu, agar Admin bisa turu <br><br>^_^</p>
            <p><b>Visi Admin</b><br>Menjadi Miliarder di 2030, dengan modal turu!</p>
            <p><b>Misi Admin</b><br>
                1. Turu <br>
                2. Turu <br>
                3. Turu <br>
                4. Melupakan masa lalu <br>
                5. Untuk mencari yang baru</p>
            <p><b>Mars Admin</b><br>
                <q>
                    hooo... <br>
                    woo.... <br>
                    Mati... tak bisa untuk kau hindari <br>
                    Tak mungkin bisa engkau lari <br>
                    Ajal mu pasti menghampiri <br>
                    <br>
                    Mati... tinggal menunggu saat nanti <br>
                    Kemana kita bisa lari <br>
                    Kita pastikan mengalami
                </q>
                <br><br>
                <i><q>Ungu - Bila Tiba</q></i>
            </p>

            <p><b>Motto Admin</b><br><br>
                KAYA, KAYA, KAYAAAAAA!</p>
            <p>Terimakasih</p>
            <a href="logout.php" class="btn">Logout</a>
            <a href="ganti_pass.php" target="_blank" class="btn">Ganti Password</a>
        </div>
    </div>
    <div class="teks">
        <h3 class="judul">Daftar User</h3>
    </div>

    <form action="" method="post">
        <input type="text" name="keyword" autofocus placeholder="Enter keyword for search!" autocomplete="off">
        <button type="submit" name="cari" class="btn">Search!</button>
    </form>

    <a href="create.php">Add New User</a>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Aksi</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($table as $t) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td>
                        <a href="update.php?id=<?= $t["id"]; ?>">Update</a> |
                        <a href="delete.php?id=<?= $t["id"]; ?>" onclick="return confirm('yakin?');">Delete</a>
                    </td>
                    <td><?= $t["username"]; ?></td>
                    <td><?= $t["email"]; ?></td>
                    <td><?= $t["password"]; ?></td>
                    <td><?= $t["level"]; ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>