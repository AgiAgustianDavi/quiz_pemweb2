<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Lokasi penyimpanan gambar
    $lokasi = 'img/';

    // Path lengkap file gambar
    $path = $lokasi . $file;

    // Periksa apakah file ada
    if (file_exists($path)) {
        // Set header untuk melakukan download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));

        // Baca file dan kirimkan ke output buffer
        readfile($path);
        exit;
    } else {
        echo "File not found!";
    }
}
?>
