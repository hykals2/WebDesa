<?php 
$page_title = "Edit Struktur Desa";
include 'template/header.php'; 
include 'template/sidebar.php';

// Proses Update Data (ketika tombol "Simpan Semua Perubahan" diklik)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_struktur'])) {
    $sukses = true;
    foreach ($_POST['nama'] as $id => $nama) {
        $jabatan = $_POST['jabatan'][$id];
        
        // Ambil nama foto lama dari database
        $stmt_old = mysqli_prepare($conn, "SELECT foto FROM struktur_desa WHERE id=?");
        mysqli_stmt_bind_param($stmt_old, "i", $id);
        mysqli_stmt_execute($stmt_old);
        $foto_lama = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_old))['foto'];
        $nama_foto_db = $foto_lama;

        // Cek jika ada foto baru yang diupload untuk baris ini
        if (isset($_FILES['foto']['name'][$id]) && !empty($_FILES['foto']['name'][$id])) {
            $nama_foto_baru = $_FILES['foto']['name'][$id];
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
            if (move_uploaded_file($_FILES['foto']['tmp_name'][$id], $target_dir . $nama_foto_baru)) {
                $nama_foto_db = $nama_foto_baru;
                // Hapus foto lama jika bukan file default
                if ($foto_lama != 'default.png' && $foto_lama != 'default-profil.jpg' && file_exists($target_dir . $foto_lama)) {
                    unlink($target_dir . $foto_lama);
                }
            }
        }
        
        // Update data di database
        $stmt_update = mysqli_prepare($conn, "UPDATE struktur_desa SET nama=?, jabatan=?, foto=? WHERE id=?");
        mysqli_stmt_bind_param($stmt_update, "sssi", $nama, $jabatan, $nama_foto_db, $id);
        if(!mysqli_stmt_execute($stmt_update)) {
            $sukses = false;
        }
    }
    // Arahkan kembali dengan status yang sesuai
    if($sukses) {
        header("Location: struktur.php?status=sukses");
        exit;
    } else {
        header("Location: struktur.php?status=gagal");
        exit;
    }
}
?>

<!-- Kontainer Utama Konten -->
<div class="flex-1 flex flex-col">
    <!-- Header Konten -->
    <header class="bg-gray-100 p-6 flex justify-between items-center">
        <button id="sidebar-toggle" class="text-gray-600 hover:text-primary lg:hidden"><i class="fas fa-bars fa-lg"></i></button>
        <h1 class="text-2xl font-bold text-gray-800"><?php echo $page_title; ?></h1>
        <a href="tambah-jabatan.php" class="bg-accent hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center space-x-2 text-sm">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Jabatan</span>
        </a>
    </header>

    <!-- Area Konten Utama Halaman -->
    <main class="flex-1 p-6">
        
        <!-- Pesan Notifikasi -->
        <?php if (isset($_GET['status'])): ?>
            <?php
                // Tentukan gaya dan judul berdasarkan status
                $is_success = in_array($_GET['status'], ['sukses', 'ditambah', 'dihapus', 'fotodihapus']);
                $alert_class = $is_success ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
                $alert_title = $is_success ? 'Sukses!' : 'Gagal!';
            ?>
            <div class="<?php echo $alert_class; ?> border-l-4 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold"><?php echo $alert_title; ?></p>
                <p>
                    <?php 
                        if ($_GET['status'] == 'sukses') echo 'Data struktur desa berhasil diperbarui.';
                        if ($_GET['status'] == 'ditambah') echo 'Jabatan baru berhasil ditambahkan.';
                        if ($_GET['status'] == 'dihapus') echo 'Jabatan berhasil dihapus.';
                        if ($_GET['status'] == 'fotodihapus') echo 'Foto berhasil dihapus dan dikembalikan ke default.';
                        if ($_GET['status'] == 'gagal') echo 'Terjadi kesalahan saat memperbarui data.';
                    ?>
                </p>
            </div>
        <?php endif; ?>
        
        <div class="bg-white shadow-lg rounded-xl p-6">
            <form action="struktur.php" method="post" enctype="multipart/form-data">
                <div class="space-y-6">
                    <?php
                    $sql = "SELECT * FROM struktur_desa ORDER BY id ASC";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)):
                    ?>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center border-b border-gray-200 pb-6">
                        <!-- Kolom Jabatan -->
                        <div>
                            <label class="block font-semibold text-gray-600 mb-1">Jabatan</label>
                            <input type="text" name="jabatan[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['jabatan']); ?>" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <!-- Kolom Nama -->
                        <div>
                            <label class="block font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['nama']); ?>" class="w-full bg-gray-50 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <!-- Kolom Foto -->
                        <div>
                            <label class="block font-semibold text-gray-600 mb-1">Ganti Foto</label>
                            <div class="flex items-center space-x-4">
                                <img src="/uploads/<?php echo htmlspecialchars($row['foto']); ?>" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                                <div class="flex-grow">
                                    <input type="file" name="foto[<?php echo $row['id']; ?>]" class="text-sm text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer">
                                    <?php if ($row['foto'] != 'default.png' && $row['foto'] != 'default-profil.jpg'): ?>
                                        <a href="hapus-foto-struktur.php?id=<?php echo $row['id']; ?>" class="text-xs text-red-500 hover:underline mt-1 block" onclick="return confirm('Yakin ingin hapus foto ini dan kembali ke default?')">Hapus Foto</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Hapus Jabatan -->
                        <div class="text-right">
                            <a href="hapus-jabatan.php?id=<?php echo $row['id']; ?>" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-md text-xs transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus jabatan ini? Menghapus akan permanen.')">Hapus Jabatan</a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <div class="mt-8 text-right">
                    <button type="submit" name="update_struktur" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-lg transition-colors">Simpan Semua Perubahan</button>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include 'template/footer.php'; ?>