<?php

$conn = mysqli_connect("localhost", "root", "", "toko_online");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function kirim_email($email_penerima, $nama_penerima, $judul_email, $isi_email)
{

    $email_pengirim = "09021282227118@student.unsri.ac.id";
    $nama_pengirim = "noreply";

    //Load Composer's autoloader
    require getcwd() . '/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $email_pengirim;                     //SMTP username
        $mail->Password   = 'password email(privasi yah)';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($email_pengirim, $nama_pengirim);
        $mail->addAddress($email_penerima, $nama_penerima);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $judul_email;
        $mail->Body    = $isi_email;

        $mail->send();
        return "sukses";
    } catch (Exception $e) {
        return "gagal: {$mail->ErrorInfo}";
    }
}

function create($data)
{
    global $conn;
    // ambil data dari tiap elemen dalam form
    $username = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $password = htmlspecialchars($data["password"]);
    $level = htmlspecialchars($data["level"]);

    // upload gambar
    $gambar = upload();

    if (!$gambar) {
        return false;
    }

    mysqli_query($conn, "insert into users(username,email,password,gambar,level) values('$username','$email','$password','$gambar','$level')");

    return mysqli_affected_rows($conn);
}

function delete($id)
{
    global $conn;

    mysqli_query($conn, "delete * from users  WHERE id =$id");

    return mysqli_affected_rows($conn);
}

function update($data)
{
    global $conn;
    // ambil data dari tiap elemen dalam form
    $id = $data["id"];
    $username = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $password = htmlspecialchars($data["password"]);
    $level = htmlspecialchars($data["level"]);

    $gambarlama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarlama;
    } else {
        $gambar = upload();
    }

    mysqli_query($conn, "update users set username='$username',email='$email',password='$password',gambar='$gambar',level='$level' where id=$id");

    return mysqli_affected_rows($conn);
}

function search($keyword)
{
    $query = "select * from users 
                where 
                username LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                level LIKE '%$keyword%' 
            ";
    return query($query);
}

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error == 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu!');</script>";
        return false;
    }

    // cek apakah yang diupload gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png']; // jenis gambar yang diizinkan
    $ekstensiGambar = explode('.', $namaFile); // memecah nama file gambar (ex : agi.jpg menjadi array ['agi','jpg'])
    $ekstensiGambar = strtolower(end($ekstensiGambar)); 
     // mendapatkan ekstensi gambar dari nama file
    // dan fungsi strtolower() untuk mengubah huruf besar menjadi huruf kecil karena JPG dan jpg itu berbeda 
    // sehingga JPG di kecilkan jadi jpg dan sesuai dengan yang ditentukan diatas
    // if (!in_array($ekstensiGambar, $ekstensiGambarValid)) { // cek ke-validan file yang di upload (harus gambar)
    //     echo "<script>alert('ERROR! Anda wajib mengupload gambar dengan type : jpg, jpeg, atau png!');</script>";
    //     return false;
    // }

    // cek jika ukuran gambar terlalu besar
    if ($ukuranFile > 5000000) { // 5.000.000 byte == 5 MB
        echo "<script>alert('Ukuran file gambar yang di upload terlalu besar!');</script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload

    // generate nama gambar baru
    $namaFileBaru = uniqid(); // fungsi uniqid() mengenerate angka random
    $namaFileBaru .='.';
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpName, 'img/'.$namaFileBaru);

    return $namaFileBaru;
}
