<?php
session_start();
if (!isset($_SESSION["login"])) { // jika tidak ada sesi login maka tendang user ke halaman login
    header("location: login.php");
    exit;
}
require 'functions.php';

$id = $_GET['id'];

$table = query("select * from users where id=$id")[0];

if (isset($_POST['submit'])) {
    if (update($_POST) > 0) {
        echo "
        <script>
            alert('data berhasil diubah!');
            document.location.href = 'admin_dashboard.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('data gagal diubah!');
            document.location.href = 'admin_dashboard.php';
        </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data | Toko Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <form action="" method="post" class="container">
            <h2 class="judul">Update Data</h2>
            <input type="hidden" name="id" value="<?= $table['id']; ?>">
            <ul>
                <li>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" required value="<?= $table['username']; ?>" >
                </li>
                <li>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required value="<?= $table['email']; ?>" >
                </li>
                <li>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your Password" required value="<?= $table['password']; ?>" >
                </li>
                <li>
                    <label for="level">Level</label>
                    <select name="level">
                        <option selected>Pilih Level</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </li>
                <li>
                    <button type="submit" name="submit">Update data!</button>
                </li>
            </ul>
        </form>
    </div>
</body>

</html>