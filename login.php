<?php
session_start();
require 'functions.php';

$username = '';
$email = '';
$err = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql1 = mysqli_query($conn, "select * from users where username = '$username' and email = '$email' and password = '$password' ");

    //cek kesesuaian input dengan db
    if (mysqli_num_rows($sql1) === 1) {
        $row = mysqli_fetch_assoc($sql1);
        $_SESSION['login'] = $username;
        $_SESSION['level'] = $row['level'];
        if ($row['level'] == 'admin') {
            header("location: admin_dashboard.php");
        } else {
            header("location: user_dashboard.php");
        }
        exit;
    } else {
        $err = "Username/email/password tidak sesuai.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Toko Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form action="" method="post" class="container">
        <h2 class="judul">Login</h2>
        <div class="err_msg">
            <?php if ($err) {
                echo $err;
            } ?>
        </div>
        <ul>
            <li>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
            </li>
            <li>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your Password" required>
            </li>
            <li>
                <button type="submit" name="login" class="btn">Login</button>
            </li>
            <a type="submit" href="forgot_pass.php" target="_blank">Forgot Password?</a>
            <div class="teks">
                <p>Belum mempunyai akun?</p>
                <a href="register.php">Daftar disini!</a>
            </div>
        </ul>
    </form>
</body>

</html>