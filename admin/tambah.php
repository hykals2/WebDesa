<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
require_once 'db.php';
$error_message = ''; // Variabel untuk menyimpan pesan error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    
    // Pastikan ada file yang diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar']['name'];

        // === PERUBAHAN UTAMA DI SINI ===
        // Menggunakan path absolut untuk keandalan
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        
        $target_file = $target_dir . basename($gambar);
        
        // Coba pindahkan file yang diupload
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Jika berhasil, simpan ke database
            $stmt = mysqli_prepare($conn, "INSERT INTO berita (judul, isi, gambar) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $judul, $isi, $gambar);
            
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php"); // Arahkan ke dashboard jika sukses
                exit;
            } else {
                $error_message = "Error: Gagal menyimpan data ke database. " . mysqli_error($conn);
            }
        } else {
            $error_message = "Error: Gagal mengupload file gambar.";
        }
    } else {
        $error_message = "Error: Anda harus memilih file gambar.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Berita</title>
    <!-- Salin head dari berita/index.php -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { primary: "#1e40af", secondary: "#1e3a8a", accent: "#f59e0b" } } } }
    </script>
</head>
<body class="bg-gray-100">
    <header class="bg-primary text-white shadow-md">
        <div class="container mx-auto px-4 flex justify-between items-center py-3">
            <h1 class="text-xl font-bold">Panel Admin - Tambah Berita</h1>
            <div>
                <a href="index.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg mr-2">Kembali</a>
                <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">Logout</a>
            </div>
        </div>
    </header>
    <main class="py-10">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-6">Formulir Berita Baru</h2>

                <?php if(!empty($error_message)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline"><?php echo $error_message; ?></span>
                    </div>
                <?php endif; ?>

                <form action="tambah.php" method="post" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label for="judul" class="block font-bold">Judul Berita</label>
                        <input id="judul" type="text" name="judul" class="w-full p-2 border rounded" required>
                    </div>
                    <div>
                        <label for="isi" class="block font-bold">Isi Berita</label>
                        <textarea id="isi" name="isi" rows="10" class="w-full p-2 border rounded" required></textarea>
                    </div>
                    <div>
                        <label for="gambar" class="block font-bold">Gambar Utama</label>
                        <input id="gambar" type="file" name="gambar" class="w-full" required>
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-2 px-4 rounded-lg">Simpan Berita</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>