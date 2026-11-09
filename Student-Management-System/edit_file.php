<?php
date_default_timezone_set("Asia/Jakarta");

session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit;
}

$upload_folder = __DIR__ . "/uploads/";
if (!is_dir($upload_folder)) {
    mkdir($upload_folder, 0777, true);
}

if (isset($_POST['edit_file'])) {
    $id = $_POST['id_mahasiswa'];
    $old_file = $_POST['old_file'];
    $new_file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $target_file = $upload_folder . basename($new_file);

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
    $file_extension = strtolower(pathinfo($new_file, PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        $_SESSION['eksekusi'] = "Format file tidak diizinkan!";
        header("Location: mahasiswa.php");
        exit;
    }

    if (!empty($new_file)) {
        if (move_uploaded_file($tmp, $target_file)) {
            // Hapus file lama jika ada
            if (!empty($old_file) && file_exists($upload_folder . $old_file)) {
                unlink($upload_folder . $old_file);
            }

            $tanggal_upload = date('Y-m-d H:i:s');
            $query = "UPDATE mahasiswa_kelas SET file='$new_file', tanggal_upload='$tanggal_upload' WHERE id_mahasiswa='$id'";

            if (mysqli_query($conn, $query)) {
                $_SESSION['eksekusi'] = "File berhasil diperbarui.";
            } else {
                $_SESSION['eksekusi'] = "Gagal menyimpan data: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['eksekusi'] = "Gagal mengunggah file baru.";
        }
    } else {
        $_SESSION['eksekusi'] = "File baru tidak ditemukan.";
    }

    header("Location: mahasiswa.php");
    exit;
}
