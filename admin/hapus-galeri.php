<?php
// Langkah 1: Memulai session dan memeriksa login untuk keamanan
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke file koneksi database
require_once 'db.php';

// Langkah 2: Memeriksa apakah 'id' foto dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // --- Langkah 3: Menghapus file gambar dari folder /uploads ---
    // Ambil nama file dari database terlebih dahulu
    $stmt_select = mysqli_prepare($conn, "SELECT nama_file FROM galeri WHERE id = ?");
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);
    
    if ($row = mysqli_fetch_assoc($result_select)) {
        $nama_file_gambar = $row['nama_file'];
        $path_file_gambar = '/uploads/' . $nama_file_gambar;

        // Periksa apakah file gambar benar-benar ada, lalu hapus
        if (file_exists($path_file_gambar)) {
            unlink($path_file_gambar); // Fungsi PHP untuk menghapus file
        }

        // --- Langkah 4: Menghapus record foto dari database ---
        $stmt_delete = mysqli_prepare($conn, "DELETE FROM galeri WHERE id = ?");
        mysqli_stmt_bind_param($stmt_delete, "i", $id);

        // Eksekusi query penghapusan
        if (mysqli_stmt_execute($stmt_delete)) {
            // Jika berhasil, kembalikan ke halaman galeri dengan notifikasi
            header("Location: galeri.php?status=dihapus");
            exit;
        } else {
            // Tampilkan pesan error jika query gagal
            echo "Error: Gagal menghapus foto dari database.";
        }
    } else {
        echo "Error: Foto dengan ID tersebut tidak ditemukan.";
    }

} else {
    // Jika tidak ada 'id' di URL, kembalikan ke halaman galeri
    header("Location: galeri.php");
    exit;
}
?>