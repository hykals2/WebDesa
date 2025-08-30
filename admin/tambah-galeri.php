// File: admin/tambah-galeri.php
<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) { exit; }
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['gambar'])) {
    $gambar = $_FILES['gambar']['name'];
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
    $target_file = $target_dir . basename($gambar);
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO galeri (nama_file) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $gambar);
        mysqli_stmt_execute($stmt);
    }
}
header("Location: galeri.php");
exit;
?>

// File: admin/hapus-galeri.php
<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) { exit; }
require_once 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt_select = mysqli_prepare($conn, "SELECT nama_file FROM galeri WHERE id = ?");
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);
    if ($row = mysqli_fetch_assoc($result_select)) {
        $path_file = '/uploads/' . $row['nama_file'];
        if (file_exists($path_file)) { unlink($path_file); }
    }
    $stmt_delete = mysqli_prepare($conn, "DELETE FROM galeri WHERE id = ?");
    mysqli_stmt_bind_param($stmt_delete, "i", $id);
    mysqli_stmt_execute($stmt_delete);
}
header("Location: galeri.php");
exit;
?>