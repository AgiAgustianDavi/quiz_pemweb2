<?php
require 'functions.php';

$err = '';
$sukses = '';
if (isset($_POST['kirim_email'])) {
    $email = $_POST['email'];
    //cek apakah email terdapat dalam db
    $sql1 = mysqli_query($conn, "select * from users where email = '$email'");
    $n1 = mysqli_fetch_assoc($sql1);
    if (mysqli_num_rows($sql1) === 1) {
        //kirim email untuk ganti password
        $username = $n1['username'];
        $judul_email = "Konfirmasi ganti password";
        $isi_email = "<b>$email</b> Melakukan request forgot password. Apakah ini kamu?<br>";
        $isi_email .= "<b>JIKA INI KAMU</b>, Silahkan klik link di bawah ini untuk proses berikutnya.<b> JIKA BUKAN KAMU</b>, abaikan pesan ini.<br>";
        $isi_email .= "<a href='http://localhost/quiz/reset_pass.php?email=$email' style='display: inline-block; background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Verifikasi disini</a>";

        kirim_email($email, $username, $judul_email, $isi_email);
        $sukses = "Proses berhasil, silahkan cek email kamu.";
    } else {
        $err = "Email tidak terdaftar!";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password | Toko Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form action="" method="POST" class="container" >
        <h2 class="judul" >Forgot Password</h2>
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
                <label for="email">Masukkan Email yang terdaftar sebagai akun</label>
                <input type="email" id="email" name="email" id="email" placeholder="Enter your email" required>
            </li>
            <li>
                <button type="submit" name="kirim_email" class="btn" >Kirim Email</button>
            </li>
        </ul>
    </form>
</body>

</html>