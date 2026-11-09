<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login dan memiliki peran dosen
if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['role'] !== 'dosen') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi dan sanitasi input
    $id_mahasiswa = isset($_POST['id_mahasiswa']) ? intval($_POST['id_mahasiswa']) : 0;
    $nilai = isset($_POST['nilai']) ? trim($_POST['nilai']) : '';
    $catatan = isset($_POST['catatan']) ? trim($_POST['catatan']) : '';

    // Cek apakah input valid
    if ($id_mahasiswa > 0 && $nilai !== '') {
        // Gunakan prepared statement untuk keamanan
        $stmt = $conn->prepare("UPDATE mahasiswa_kelas SET nilai = ?, catatan = ? WHERE id_mahasiswa = ?");
        $stmt->bind_param("ssi", $nilai, $catatan, $id_mahasiswa);

        if ($stmt->execute()) {
            $_SESSION['eksekusi'] = "Nilai dan catatan berhasil disimpan!";
        } else {
            $_SESSION['eksekusi'] = "Gagal menyimpan nilai: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['eksekusi'] = "Data tidak lengkap atau tidak valid.";
    }

    header("Location: dosen.php");
    exit;
}
