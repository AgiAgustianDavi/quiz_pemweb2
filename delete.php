<?php
session_start();
if(!isset($_SESSION["login"])) { // jika tidak ada sesi login maka tendang user ke halaman login
    header("location: login.php");
    exit;
}
require 'functions.php';
    // ambil data di URL
    $id = $_GET["id"];

    if(delete($id) > 0) {
        echo "
            <script>
                alert('data berhasil dihapus!');
                document.location.href = 'admin_dashboard.php';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('data gagal dihapus!');
                document.location.href = 'admin_dashboard.php';
            </script>
            ";
    }
?>