<?php 
$page_title = "Tambah Berita Baru";
include 'template/header.php'; 
include 'template/sidebar.php';

$error_message = '';

// Proses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    
    // Pastikan ada file yang diupload dan tidak ada error
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        $target_file = $target_dir . basename($gambar);
        
        // Coba pindahkan file yang diupload
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Jika berhasil, simpan ke database
            $stmt = mysqli_prepare($conn, "INSERT INTO berita (judul, isi, gambar) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $judul, $isi, $gambar);
            
            if (mysqli_stmt_execute($stmt)) {
                header("Location: berita.php?status=ditambah"); // Arahkan ke halaman berita jika sukses
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

<!-- Kontainer Utama Konten -->
<div class="flex-1 flex flex-col">
    <!-- Header Konten -->
    <header class="bg-gray-100 p-6 flex justify-between items-center">
        <button id="sidebar-toggle" class="text-gray-600 hover:text-primary lg:hidden"><i class="fas fa-bars fa-lg"></i></button>
        <h1 class="text-2xl font-bold text-gray-800"><?php echo $page_title; ?></h1>
        <a href="berita.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors text-sm">
            &larr; Batal
        </a>
    </header>

    <!-- Area Konten Utama Halaman -->
    <main class="flex-1 p-6">
        
        <!-- Pesan Notifikasi Error (jika ada) -->
        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold">Gagal!</p>
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>
        
        <div class="bg-white shadow-lg rounded-xl p-6">
            <form action="tambah-berita.php" method="post" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="judul" class="block font-semibold text-gray-600 mb-1">Judul Berita</label>
                    <input type="text" id="judul" name="judul" placeholder="Masukkan judul berita..." class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <div>
                    <label for="isi" class="block font-semibold text-gray-600 mb-1">Isi Berita</label>
                    <textarea id="isi" name="isi" rows="10" placeholder="Tulis isi berita di sini..." class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required></textarea>
                </div>
                <div>
                    <label for="gambar" class="block font-semibold text-gray-600 mb-1">Gambar Utama</glabel>
                    <input id="gambar" type="file" name="gambar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer" required>
                </div>
                <div class="mt-8 text-right">
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-lg transition-colors">Simpan Berita</button>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include 'template/footer.php'; ?>