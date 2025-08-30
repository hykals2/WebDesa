<?php
// Langkah 1: Selalu mulai session di awal
session_start();

// Langkah 2: Hapus semua variabel session yang telah terdaftar
// Ini membersihkan semua data yang tersimpan, seperti $_SESSION['loggedin']
$_SESSION = array();

// Langkah 3: Hancurkan session secara total
// Ini akan menghapus file session di server
session_destroy();

// Langkah 4: Arahkan (redirect) pengguna kembali ke halaman login
// Pengguna sekarang sudah tidak lagi dianggap login
header("Location: ../index.php"); 
exit; // Pastikan untuk keluar dari script setelah redirect
?>