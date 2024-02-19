<?php
require 'functions.php';

$username = '';
$email = '';
$err = '';
$sukses = '';

if (isset($_POST["register"])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    $level = $_POST['level'];

    //cek username apakah sudah digunakan sebelumnya
    $sql1 = mysqli_query($conn, "select username from users where username = '$username'");
    if (mysqli_num_rows($sql1) < 1) {

        //cek email apakah sudah digunakan sebelumnya
        $sql2 = mysqli_query($conn, "select email from users where email = '$email'");
        if (mysqli_num_rows($sql2) < 1) {

            //cek kesesuaian pass dengan konfir pass
            if ($password === $konfirmasi_password) {

                //cek inputan level
                if ($level === 'user' || $level === 'admin') {

                    //kirim email
                    $judul_email = "Halaman Konfirmasi Pendaftaran";
                    $isi_email = "Akun yang kamu miliki dengan email <b>$email</b> telah siap digunakan.<br>";
                    $isi_email .= "Silahkan melakukan aktivasi akun di link di bawah ini.<br>";
                    $isi_email .= "<a href='http://localhost/quiz/verifikasi_register.php' style='display: inline-block; background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Verifikasi disini</a>";

                    kirim_email($email, $username, $judul_email, $isi_email);

                    $insert = mysqli_query($conn, "insert into users(username,email,password,level)values('$username','$email','$password','$level')");
                    if ($insert) {
                        $sukses = "Proses berhasil. Silahkan cek email kamu untuk verifikasi";
                    }
                } else {
                    $err .= "Silahkan pilih level!";
                }
            } else {
                $err .= "Password dan Konfirmasi Password tidak sesuai!";
            }
        } else {
            $err .= "Email sudah terdaftar.";
        }
    } else {
        $err .= "Username sudah digunakan.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Toko Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form action="" method="post" class="container">
        <h2 class="judul">Registrasi akun</h2>
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
                <label for="konfirmasi_password">Konfirmasi Password</label>
                <input type="password" name="konfirmasi_password" id="konfirmasi_password" placeholder="Enter your confirm Password" required>
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
                <button type="submit" name="register" class="btn">Sign up</button>
            </li>
            <div class="teks">
                <p>Sudah punya akun?</p>
                <a href="login.php">Login disini!</a>
            </div>
        </ul>
    </form>
</body>

</html>