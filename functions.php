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

    mysqli_query($conn, "insert into users(username,email,password,level) values('$username','$email','$password','$level')");

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

    mysqli_query($conn, "update users set username='$username',email='$email',password='$password',level='$level' where id=$id");

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
