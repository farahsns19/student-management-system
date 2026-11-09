<?php
date_default_timezone_set("Asia/Jakarta");

session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_is_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Pastikan folder uploads ada
$upload_folder = __DIR__ . "/uploads/";
if (!is_dir($upload_folder)) {
    mkdir($upload_folder, 0777, true); // buat folder jika belum ada
}

if (isset($_POST['upload'])) {
    $id = $_POST['id_mahasiswa'];
    $file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $target_file = $upload_folder . basename($file);

    // Validasi ekstensi file
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
    $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        $_SESSION['eksekusi'] = "Format file tidak diizinkan!";
        header("Location: mahasiswa.php");
        exit;
    }

    if (!empty($file)) {
        if (move_uploaded_file($tmp, $target_file)) {
            $tanggal_upload = date('Y-m-d H:i:s');

            // Simpan nama file dan tanggal upload ke database
            $query = "UPDATE mahasiswa_kelas SET file='$file', tanggal_upload='$tanggal_upload' WHERE id_mahasiswa='$id'";
            if (mysqli_query($conn, $query)) {
                $_SESSION['eksekusi'] = "File berhasil diupload.";
            } else {
                $_SESSION['eksekusi'] = "Gagal menyimpan data ke database: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['eksekusi'] = "Gagal mengunggah file.";
        }
    } else {
        $_SESSION['eksekusi'] = "File tidak ditemukan.";
    }

    header("Location: mahasiswa.php");
    exit;
}
