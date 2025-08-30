<?php 
// Pindahkan seluruh logika PHP ke atas, sebelum HTML apa pun
$page_title = "Edit Data Desa";
include 'template/header.php'; // Ini sekarang hanya akan berisi session_start dan db.php dari header.php

// === LOGIKA PEMROSESAN FORM DIPINDAHKAN KE SINI ===
// Proses Update Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $penduduk = $_POST['penduduk'];
    $kk = $_POST['kk'];
    $wilayah = $_POST['wilayah'];
    $hari_jadi = $_POST['hari_jadi'];
    
    $stmt = mysqli_prepare($conn, "UPDATE info_desa SET jumlah_penduduk=?, jumlah_kk=?, luas_wilayah=?, hari_jadi=? WHERE id = 1");
    mysqli_stmt_bind_param($stmt, "ssss", $penduduk, $kk, $wilayah, $hari_jadi);
    
    if(mysqli_stmt_execute($stmt)) {
        header("Location: data-desa.php?status=sukses");
        exit;
    } else {
        header("Location: data-desa.php?status=gagal");
        exit;
    }
}
// === AKHIR DARI LOGIKA PEMROSESAN ===


// Mengambil data saat ini untuk ditampilkan di form (setelah logika redirect)
$info_result = mysqli_query($conn, "SELECT * FROM info_desa WHERE id = 1");
$info = mysqli_fetch_assoc($info_result);

// Sekarang, setelah semua logika selesai, baru kita sertakan bagian visual
include 'template/sidebar.php'; 
?>

<!-- Kontainer Utama Konten -->
<div class="flex-1 flex flex-col">
    <!-- Header Konten -->
    <header class="bg-gray-100 p-6 flex justify-between items-center">
        <button id="sidebar-toggle" class="text-gray-600 hover:text-primary lg:hidden"><i class="fas fa-bars fa-lg"></i></button>
        <h1 class="text-2xl font-bold text-gray-800"><?php echo $page_title; ?></h1>
        <div></div> <!-- Spacer -->
    </header>

    <!-- Area Konten Utama Halaman -->
    <main class="flex-1 p-6">
        
        <!-- Pesan Notifikasi -->
        <?php if (isset($_GET['status'])): ?>
            <div class="<?php echo $_GET['status'] == 'sukses' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700'; ?> border-l-4 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold"><?php echo $_GET['status'] == 'sukses' ? 'Sukses!' : 'Gagal!'; ?></p>
                <p><?php echo $_GET['status'] == 'sukses' ? 'Data desa berhasil diperbarui.' : 'Terjadi kesalahan saat memperbarui data.'; ?></p>
            </div>
        <?php endif; ?>
        
        <div class="bg-white shadow-lg rounded-xl p-6">
             <form action="data-desa.php" method="post" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="penduduk" class="block font-semibold text-gray-600 mb-1">Jumlah Penduduk</label>
                        <input type="text" id="penduduk" name="penduduk" value="<?php echo htmlspecialchars($info['jumlah_penduduk']); ?>" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Contoh: 5.243 Jiwa">
                    </div>
                    <div>
                        <label for="kk" class="block font-semibold text-gray-600 mb-1">Jumlah KK</label>
                        <input type="text" id="kk" name="kk" value="<?php echo htmlspecialchars($info['jumlah_kk']); ?>" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Contoh: 1.532 Keluarga">
                    </div>
                    <div>
                        <label for="wilayah" class="block font-semibold text-gray-600 mb-1">Luas Wilayah</label>
                        <input type="text" id="wilayah" name="wilayah" value="<?php echo htmlspecialchars($info['luas_wilayah']); ?>" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Contoh: 12,5 Km²">
                    </div>
                    <div>
                        <label for="hari_jadi" class="block font-semibold text-gray-600 mb-1">Hari Jadi</label>
                        <input type="text" id="hari_jadi" name="hari_jadi" value="<?php echo htmlspecialchars($info['hari_jadi']); ?>" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Contoh: 12 April 1985">
                    </div>
                </div>

                <div class="mt-8 text-right">
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-lg transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include 'template/footer.php'; ?>