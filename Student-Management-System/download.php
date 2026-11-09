<?php
if (isset($_GET['file'])) {
    $file = $_GET['file']; // Mendapatkan nama file dari URL
    $filepath = __DIR__ . '/uploads/' . basename($file); // Pastikan path aman

    if (file_exists($filepath)) {
        // Set header untuk memberi tahu browser untuk mengunduh file
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=" . basename($filepath));
        header('Content-Length: ' . filesize($filepath));

        // Baca dan kirimkan file ke browser
        readfile($filepath);
        flush();
        exit;
    } else {
        echo "File tidak ditemukan.";
    }
} else {
    echo "Tidak ada file yang dipilih.";
}

