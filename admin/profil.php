<?php 
// Pindahkan seluruh logika PHP ke atas, sebelum HTML apa pun
$page_title = "Edit Profil Desa";
// Header.php berisi session_start() dan koneksi DB, jadi ini harus di atas.
include 'template/header.php'; 

$error_message = '';

// === LOGIKA PEMROSESAN FORM DIPINDAHKAN KE SINI ===
// Proses Update Data saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $sejarah = $_POST['sejarah'];
    $visi = $_POST['visi'];
    $misi = $_POST['misi'];
    $foto_lama = $_POST['foto_lama'];
    $nama_foto_db = $foto_lama;

    // Cek jika ada foto baru diupload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0 && !empty($_FILES['foto']['name'])) {
        $nama_foto_baru = $_FILES['foto']['name'];
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $nama_foto_baru)) {
            $nama_foto_db = $nama_foto_baru;
            // Hapus foto lama jika bukan file default
            if ($foto_lama != 'default.png' && $foto_lama != 'default-profil.jpg' && file_exists($target_dir . $foto_lama)) {
                unlink($target_dir . $foto_lama);
            }
        } else {
            // Jika upload gagal, siapkan pesan error tapi jangan hentikan script
            $error_message = "Gagal mengupload foto baru.";
        }
    }
    
    // Lanjutkan hanya jika tidak ada error upload
    if (empty($error_message)) {
        // Update data di database
        $stmt = mysqli_prepare($conn, "UPDATE profil_desa SET deskripsi=?, foto=?, lokasi=?, telepon=?, email=?, sejarah=?, visi=?, misi=? WHERE id = 1");
        mysqli_stmt_bind_param($stmt, "ssssssss", $deskripsi, $nama_foto_db, $lokasi, $telepon, $email, $sejarah, $visi, $misi);
        
        if(mysqli_stmt_execute($stmt)) {
            // Redirect jika SUKSES
            header("Location: profil.php?status=sukses");
            exit;
        } else {
            // Jika gagal simpan ke DB, siapkan pesan error
            $error_message = "Gagal menyimpan data ke database.";
        }
    }
}
// === AKHIR DARI LOGIKA PEMROSESAN ===

// Mengambil data profil saat ini untuk ditampilkan di form (setelah logika redirect)
$profil_result = mysqli_query($conn, "SELECT * FROM profil_desa WHERE id = 1");
$profil = mysqli_fetch_assoc($profil_result);

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
        
        <!-- Pesan Notifikasi Sukses/Gagal -->
        <?php if (isset($_GET['status'])): ?>
            <?php
                $is_success = in_array($_GET['status'], ['sukses', 'fotodihapus']);
                $alert_class = $is_success ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
                $alert_title = $is_success ? 'Sukses!' : 'Gagal!';
            ?>
            <div class="<?php echo $alert_class; ?> border-l-4 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold"><?php echo $alert_title; ?></p>
                <p>
                    <?php 
                        if ($_GET['status'] == 'sukses') echo 'Profil desa berhasil diperbarui.';
                        if ($_GET['status'] == 'fotodihapus') echo 'Foto berhasil dihapus dan dikembalikan ke default.';
                        if ($_GET['status'] == 'gagal') echo 'Terjadi kesalahan saat memperbarui data.';
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- Menampilkan pesan error dari proses POST jika ada -->
        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold">Gagal!</p>
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>
        
        <div class="bg-white shadow-lg rounded-xl p-6">
            <form action="profil.php" method="post" enctype="multipart/form-data" class="space-y-6">
                <!-- Kontak & Foto -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-200 pb-6">
                    <div>
                        <label for="lokasi" class="block font-semibold text-gray-600 mb-1">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" value="<?php echo htmlspecialchars($profil['lokasi']); ?>" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label for="telepon" class="block font-semibold text-gray-600 mb-1">Telepon</label>
                        <input type="text" id="telepon" name="telepon" value="<?php echo htmlspecialchars($profil['telepon']); ?>" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label for="email" class="block font-semibold text-gray-600 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($profil['email']); ?>" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-600 mb-1">Ganti Foto Profil</label>
                        <div class="flex items-center space-x-4">
                            <img src="../uploads/<?php echo htmlspecialchars($profil['foto']); ?>" class="w-24 h-24 rounded-lg object-cover border-2 border-gray-200">
                            <div class="flex-grow">
                                <input type="file" name="foto" class="text-sm text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer">
                                <input type="hidden" name="foto_lama" value="<?php echo htmlspecialchars($profil['foto']); ?>">
                                
                                <?php if ($profil['foto'] != 'default.png' && $profil['foto'] != 'default-profil.jpg'): ?>
                                    <a href="hapus-foto-profil.php?id=1" class="text-xs text-red-500 hover:underline mt-1 block" onclick="return confirm('Yakin ingin hapus foto ini dan kembali ke default?')">Hapus Foto</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Deskripsi, Sejarah, Visi, Misi -->
                <div>
                    <label for="deskripsi" class="block font-semibold text-gray-600 mb-1">Deskripsi Singkat</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo htmlspecialchars($profil['deskripsi']); ?></textarea>
                </div>
                <div>
                    <label for="sejarah" class="block font-semibold text-gray-600 mb-1">Sejarah Singkat</label>
                    <textarea id="sejarah" name="sejarah" rows="6" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo htmlspecialchars($profil['sejarah'] ?? ''); ?></textarea>
                </div>
                <div>
                    <label for="visi" class="block font-semibold text-gray-600 mb-1">Visi</label>
                    <textarea id="visi" name="visi" rows="3" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo htmlspecialchars($profil['visi'] ?? ''); ?></textarea>
                </div>
                <div>
                    <label for="misi" class="block font-semibold text-gray-600 mb-1">Misi</label>
                    <textarea id="misi" name="misi" rows="6" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo htmlspecialchars($profil['misi'] ?? ''); ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Tips: Untuk membuat daftar, gunakan strip (-) atau angka (1.) di awal baris.</p>
                </div>

                <div class="mt-8 text-right">
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-lg transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include 'template/footer.php'; ?>