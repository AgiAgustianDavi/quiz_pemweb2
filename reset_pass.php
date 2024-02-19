<?php
require 'functions.php';

$err = '';
$sukses = '';
if (isset($_POST['reset_password'])) {
    $email = $_GET['email'];
    $new_password = $_POST['new_password'];
    $new_konfirmasi_password = $_POST['new_konfirmasi_password'];

    //cek apakah new pass sama dengan new konfir pass
    if ($new_password === $new_konfirmasi_password) {

        // Update password di database
        mysqli_query($conn, "UPDATE users SET password = '$new_password' WHERE email = '$email'");
        $sukses = "Password berhasil diubah! Silahkan menuju halaman login <a href='login.php'>di sini</a>";
    } else {
        $err = "Password tidak sesuai dengan konfirmasi Password.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | Toko Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form action="" method="post" class="container" >
        <h2 class="judul" >Reset Password</h2>
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
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" placeholder="Enter your new password" required>
            </li>
            <li>
                <label for="new_konfirmasi_password">Confirm New Password</label>
                <input type="password" name="new_konfirmasi_password" id="new_konfirmasi_password" placeholder="Enter your confirm new password" required>
            </li>
            <li>
                <button type="submit" name="reset_password" class="btn" >Reset Password</button>
            </li>
        </ul>
    </form>
</body>

</html>