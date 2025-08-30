<?php 
// Pindahkan seluruh logika PHP ke atas, sebelum HTML apa pun
$page_title = "Tambah Jabatan Baru";
include 'template/header.php'; // Ini sekarang hanya akan berisi session_start dan db.php dari header.php

$error_message = '';

// Proses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jabatan = $_POST['jabatan'];
    $nama = $_POST['nama'];
    $nama_foto_db = 'default.png'; // Set foto default untuk jabatan baru

    // Cek jika ada foto yang diupload dan tidak ada error
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0 && !empty($_FILES['foto']['name'])) {
        $nama_foto_baru = $_FILES['foto']['name'];
        // Menggunakan path upload yang benar untuk hosting
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        $target_file = $target_dir . basename($nama_foto_baru);
        
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $nama_foto_db = $nama_foto_baru;
        } else {
            // Gagal upload, set pesan error dan hentikan proses
            $error_message = "Gagal mengupload file gambar.";
        }
    }
    
    // Lanjutkan hanya jika tidak ada error upload
    if (empty($error_message)) {
        // Simpan data baru ke database
        $stmt = mysqli_prepare($conn, "INSERT INTO struktur_desa (jabatan, nama, foto) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $jabatan, $nama, $nama_foto_db);
        
        if(mysqli_stmt_execute($stmt)) {
            // Jika sukses, arahkan ke halaman struktur dengan notifikasi 'ditambah'
            header("Location: struktur.php?status=ditambah");
            exit;
        } else {
            // Gagal menyimpan ke DB, set pesan error
            $error_message = "Gagal menyimpan data ke database. Silakan coba lagi.";
        }
    }
}

// Setelah semua logika selesai, baru kita sertakan bagian visual
include 'template/sidebar.php'; 
?>

<!-- Kontainer Utama Konten -->
<div class="flex-1 flex flex-col">
    <!-- Header Konten -->
    <header class="bg-gray-100 p-6 flex justify-between items-center">
        <button id="sidebar-toggle" class="text-gray-600 hover:text-primary lg:hidden"><i class="fas fa-bars fa-lg"></i></button>
        <h1 class="text-2xl font-bold text-gray-800"><?php echo $page_title; ?></h1>
        <a href="struktur.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors text-sm">
            &larr; Batal
        </a>
    </header>

    <!-- Area Konten Utama Halaman -->
    <main class="flex-1 p-6">
        
        <!-- Pesan Notifikasi Gagal (dari proses upload atau DB) -->
        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold">Gagal!</p>
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>
        
        <div class="bg-white shadow-lg rounded-xl p-6">
            <form action="tambah-jabatan.php" method="post" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="jabatan" class="block font-semibold text-gray-600 mb-1">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" placeholder="Contoh: Kepala Dusun" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <div>
                    <label for="nama" class="block font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama pejabat" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <div>
                    <label for="foto" class="block font-semibold text-gray-600 mb-1">Foto (Opsional)</label>
                    <input id="foto" type="file" name="foto" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-1">Jika dikosongkan, akan menggunakan foto default.</p>
                </div>
                <div class="mt-8 text-right">
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-lg transition-colors">Simpan Jabatan Baru</button>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include 'template/footer.php'; ?>