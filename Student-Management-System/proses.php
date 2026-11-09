<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';
include 'fungsi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_is_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Proses tambah data
if ($_POST['aksi'] == 'add') {
    // Tidak kirim $_FILES ke fungsi tambah_data karena form tidak ada input file
    if (tambah_data($_POST)) {
        header("Location: index.php?pesan=berhasil_tambah");
    } else {
        echo "Gagal menambah data.";
    }
}


// Proses edit data
else if (isset($_POST['aksi']) && $_POST['aksi'] === "edit") {
    $data = array_merge($_POST, $_FILES);
    $berhasil = ubah_data($data);

    if ($berhasil) {
        $_SESSION['eksekusi'] = "Data Berhasil Diperbarui";
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal mengedit data: " . mysqli_error($GLOBALS['conn']);
    }
}

// Proses hapus data
else if (isset($_GET['hapus'])) {
    $berhasil = hapus_data($_GET);

    if ($berhasil) {
        $_SESSION['eksekusi'] = "Data Berhasil Dihapus";
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($GLOBALS['conn']);
    }
} else {
    // Jika request tidak valid, redirect ke index
    header("Location: index.php");
    exit();
}
