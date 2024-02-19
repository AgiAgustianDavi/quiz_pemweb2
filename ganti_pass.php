<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}
require 'functions.php';

$err = '';
$sukses = '';
if (isset($_POST['ubah_pass'])) {
    $old_pass = $_POST['pass_lama'];
    $new_pass = $_POST['pass_baru'];
    $con_new_pass = $_POST['konfir_pass_baru'];
    $username = $_SESSION['login'];

    //cek apakah inputan pass lama sesuai dengan yang ada di db
    $sql1 = mysqli_query($conn, "select password from users where username = '$username'");
    $q1 = mysqli_fetch_assoc($sql1);

    if ($old_pass === $q1['password']) {
        //cek new_pass === con_new_pass
        if ($new_pass === $con_new_pass) {
            mysqli_query($conn, "update users set password = '$new_pass' where username = '$username'");
            $sukses = "Password berhasil diganti";
        } else {
            $err .= "Konfirmasi Password tidak sesuai!";
        }
    } else {
        $err = "Password lama tidak sesuai!";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ganti Password | Toko Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form action="" method="post" class="container" >
        <h2 class="judul" >Ganti Password</h2>
        <ul>
            <li>
                <div class="err_msg">
                    <?php if ($err) {
                        echo $err;
                    } ?>
                </div>

                <div class="sukses_msg">
                    <?php if ($sukses) {
                        echo $sukses;
                    } ?>
                </div>
            </li>
            <li>
                <label for="pass_lama">Password Lama</label>
                <input type="password" name="pass_lama" id="pass_lama" placeholder="Enter your old password" required>
            </li>
            <li>
                <label for="pass_baru">Password Baru</label>
                <input type="password" name="pass_baru" id="pass_baru" placeholder="Enter your new password" required>
            </li>
            <li>
                <label for="konfir_pass_baru">Konfirmasi Password Baru</label>
                <input type="password" name="konfir_pass_baru" id="konfir_pass_baru" placeholder="Enter your confirm new Password" required>
            </li>
            <li>
                <button type="submit" name="ubah_pass" class="btn" >Ubah</button>
            </li>
        </ul>
    </form>
</body>

</html>