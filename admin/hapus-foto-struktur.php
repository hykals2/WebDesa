<?php
// Memulai session dan memeriksa login untuk keamanan
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

// Memeriksa apakah 'id' perangkat dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Ambil nama file foto saat ini dari database
    $stmt_select = mysqli_prepare($conn, "SELECT foto FROM struktur_desa WHERE id = ?");
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);
    
    if ($row = mysqli_fetch_assoc($result_select)) {
        $nama_file_foto = $row['foto'];
        
        // 2. Hapus file fisik jika bukan file default
        if ($nama_file_foto != 'default.png' && $nama_file_foto != 'default-profil.jpg') {
            $path_file_foto = '/uploads/' . $nama_file_foto;
            if (file_exists($path_file_foto)) {
                unlink($path_file_foto);
            }
        }

        // 3. Update record di database untuk mengatur foto kembali ke 'default.png'
        $stmt_update = mysqli_prepare($conn, "UPDATE struktur_desa SET foto = 'default.png' WHERE id = ?");
        mysqli_stmt_bind_param($stmt_update, "i", $id);

        if (mysqli_stmt_execute($stmt_update)) {
            // Jika berhasil, kembali ke halaman struktur dengan notifikasi
            header("Location: struktur.php?status=fotodihapus");
            exit;
        } else {
            // Tampilkan pesan error jika query gagal
            echo "Error: Gagal mengupdate foto di database.";
        }
    } else {
        echo "Error: Perangkat desa dengan ID tersebut tidak ditemukan.";
    }

} else {
    // Jika tidak ada 'id' di URL, kembalikan ke halaman struktur
    header("Location: struktur.php");
    exit;
}
?>