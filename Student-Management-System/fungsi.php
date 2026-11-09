<?php
include 'koneksi.php';

// Fungsi untuk menambah data mahasiswa
function tambah_data($data)
{
    $conn = $GLOBALS['conn'];

    // Sanitasi input untuk mencegah SQL Injection
    $nrp = mysqli_real_escape_string($conn, $data['nrp']);
    $nama = mysqli_real_escape_string($conn, $data['nama']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $data['jenis_kelamin']);
    $jurusan = mysqli_real_escape_string($conn, $data['jurusan']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $alamat = mysqli_real_escape_string($conn, $data['alamat']);
    $nohp = mysqli_real_escape_string($conn, $data['nohp']);
    $asal_sma = mysqli_real_escape_string($conn, $data['asal_sma']);
    $matkul_fav = mysqli_real_escape_string($conn, $data['matkul_fav']);

    // Upload file jika ada
    $file_name = '';
    if (isset($data['file']) && $data['file']['error'] == 0) {
        $file_name = uniqid() . "_" . basename($data['file']['name']);
        $file_tmp = $data['file']['tmp_name'];
        $folder = "uploads/";

        if (!move_uploaded_file($file_tmp, $folder . $file_name)) {
            // Bisa buat error handling kalau gagal upload
            return false;
        }
    }

    $query = "INSERT INTO mahasiswa_kelas (
    nrp, nama, jenis_kelamin, jurusan, email, alamat, nohp, asal_sma, matkul_fav, file, nilai
) VALUES (
    '$nrp', '$nama', '$jenis_kelamin', '$jurusan', '$email', '$alamat', '$nohp', '$asal_sma', '$matkul_fav', '$file_name', 0
)";


    return mysqli_query($conn, $query);
}

// Fungsi untuk mengubah data mahasiswa
function ubah_data($data)
{
    $conn = $GLOBALS['conn'];

    $id_mahasiswa = intval($data['id_mahasiswa']);
    $nrp = mysqli_real_escape_string($conn, $data['nrp']);
    $nama = mysqli_real_escape_string($conn, $data['nama']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $data['jenis_kelamin']);
    $jurusan = mysqli_real_escape_string($conn, $data['jurusan']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $alamat = mysqli_real_escape_string($conn, $data['alamat']);
    $nohp = mysqli_real_escape_string($conn, $data['nohp']);
    $asal_sma = mysqli_real_escape_string($conn, $data['asal_sma']);
    $matkul_fav = mysqli_real_escape_string($conn, $data['matkul_fav']);

    $query_file = "";

    if (isset($data['file']) && $data['file']['error'] == 0) {
        $file_name = uniqid() . "_" . basename($data['file']['name']);
        $file_tmp = $data['file']['tmp_name'];
        $folder = "uploads/";

        if (!move_uploaded_file($file_tmp, $folder . $file_name)) {
            return false; // Gagal upload file
        }
        $query_file = ", file='$file_name'";
    }

    $query = "UPDATE mahasiswa_kelas SET
        nrp='$nrp',
        nama='$nama',
        jenis_kelamin='$jenis_kelamin',
        jurusan='$jurusan',
        email='$email',
        alamat='$alamat',
        nohp='$nohp',
        asal_sma='$asal_sma',
        matkul_fav='$matkul_fav'
        $query_file
        WHERE id_mahasiswa=$id_mahasiswa
    ";

    return mysqli_query($conn, $query);
}

// Fungsi untuk menghapus data mahasiswa beserta file jika ada
function hapus_data($data)
{
    $conn = $GLOBALS['conn'];
    $id_mahasiswa = intval($data['hapus']);

    // Ambil nama file yang akan dihapus
    $query_file = "SELECT file FROM mahasiswa_kelas WHERE id_mahasiswa = $id_mahasiswa";
    $result = mysqli_query($conn, $query_file);
    $row = mysqli_fetch_assoc($result);

    if ($row && $row['file']) {
        $file_path = 'uploads/' . $row['file'];
        if (file_exists($file_path)) {
            unlink($file_path); // hapus file fisik
        }
    }

    // Hapus data di database
    $query = "DELETE FROM mahasiswa_kelas WHERE id_mahasiswa = $id_mahasiswa";
    return mysqli_query($conn, $query);
}
