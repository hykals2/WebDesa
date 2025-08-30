<?php
// Langkah 1: Memulai session dan memeriksa login untuk keamanan
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke file koneksi database
require_once 'db.php';

// Langkah 2: Memeriksa apakah 'id' jabatan dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // --- Langkah 3: Menghapus file foto (jika bukan foto default) ---
    // Ambil nama file foto dari database sebelum menghapus record-nya.
    $stmt_select = mysqli_prepare($conn, "SELECT foto FROM struktur_desa WHERE id = ?");
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);
    
    if ($row = mysqli_fetch_assoc($result_select)) {
        $nama_file_foto = $row['foto'];
        
        // Cek agar tidak menghapus 'default.png' atau 'default-profil.jpg'
        if ($nama_file_foto != 'default.png' && $nama_file_foto != 'default-profil.jpg') {
            $path_file_foto = '/uploads/' . $nama_file_foto;
            // Periksa apakah file foto benar-benar ada, lalu hapus
            if (file_exists($path_file_foto)) {
                unlink($path_file_foto); // Fungsi PHP untuk menghapus file
            }
        }

        // --- Langkah 4: Menghapus record jabatan dari database ---
        $stmt_delete = mysqli_prepare($conn, "DELETE FROM struktur_desa WHERE id = ?");
        mysqli_stmt_bind_param($stmt_delete, "i", $id);

        // Eksekusi query penghapusan
        if (mysqli_stmt_execute($stmt_delete)) {
            // Jika berhasil, kembalikan ke halaman struktur dengan notifikasi
            header("Location: struktur.php?status=dihapus");
            exit;
        } else {
            // Tampilkan pesan error jika query gagal
            echo "Error: Gagal menghapus jabatan dari database.";
        }
    } else {
        echo "Error: Jabatan dengan ID tersebut tidak ditemukan.";
    }

} else {
    // Jika tidak ada 'id' di URL, kembalikan ke halaman struktur
    header("Location: struktur.php");
    exit;
}
?>