<?php
// Langkah 1: Memulai session dan memeriksa apakah pengguna sudah login.
// Ini adalah langkah keamanan WAJIB untuk mencegah penghapusan data oleh orang yang tidak berwenang.
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke file koneksi database
require_once 'db.php';

// Langkah 2: Memeriksa apakah 'id' berita dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // --- Langkah 3: Menghapus file gambar terlebih dahulu ---
    // Kita perlu mengambil nama file gambar dari database sebelum menghapus record-nya.
    
    // Gunakan prepared statement untuk keamanan
    $stmt_select = mysqli_prepare($conn, "SELECT gambar FROM berita WHERE id = ?");
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);
    
    if ($row = mysqli_fetch_assoc($result_select)) {
        $nama_file_gambar = $row['gambar'];
        $path_file_gambar = '/uploads/' . $nama_file_gambar;

        // Periksa apakah file gambar benar-benar ada, lalu hapus
        if (file_exists($path_file_gambar)) {
            unlink($path_file_gambar); // Fungsi PHP untuk menghapus file
        }

        // --- Langkah 4: Menghapus record berita dari database ---
        
        // Gunakan prepared statement lagi untuk query DELETE
        $stmt_delete = mysqli_prepare($conn, "DELETE FROM berita WHERE id = ?");
        mysqli_stmt_bind_param($stmt_delete, "i", $id);

        // Eksekusi query penghapusan
        if (mysqli_stmt_execute($stmt_delete)) {
            // Jika berhasil, kembalikan pengguna ke halaman MANAJEMEN BERITA
            // dengan parameter 'status=dihapus' untuk menampilkan notifikasi
            header("Location: berita.php?status=dihapus");
            exit;
        } else {
            // Tampilkan pesan error jika query gagal
            echo "Error: Gagal menghapus berita dari database.";
        }
    } else {
        echo "Error: Berita dengan ID tersebut tidak ditemukan.";
    }

} else {
    // Jika tidak ada 'id' di URL, kembalikan saja ke halaman manajemen berita
    header("Location: berita.php");
    exit;
}
?>