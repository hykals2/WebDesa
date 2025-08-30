<?php 
$page_title = "Manajemen Berita";
include 'template/header.php'; // Memuat head dan awal body
include 'template/sidebar.php'; // Memuat sidebar
?>

<!-- Kontainer Utama Konten -->
<div class="flex-1 flex flex-col">
    <!-- Header Konten (dengan tombol hamburger) -->
    <header class="bg-gray-100 p-6 flex justify-between items-center">
        <!-- Tombol Hamburger (Hanya Tampil di Mobile) -->
        <button id="sidebar-toggle" class="text-gray-600 hover:text-primary lg:hidden">
            <i class="fas fa-bars fa-lg"></i>
        </button>
        <!-- Judul Halaman -->
        <h1 class="text-2xl font-bold text-gray-800"><?php echo $page_title; ?></h1>
        <!-- Tombol Tambah Berita -->
        <a href="tambah-berita.php" class="bg-accent hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center space-x-2 text-sm">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Berita Baru</span>
        </a>
    </header>

    <!-- Area Konten Utama Halaman -->
    <main class="flex-1 p-6">
        
        <!-- Pesan Notifikasi (jika ada dari proses hapus/edit/tambah) -->
        <?php if (isset($_GET['status'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold">Sukses!</p>
                <p>
                    <?php 
                        if ($_GET['status'] == 'ditambah') echo 'Berita baru berhasil ditambahkan.';
                        if ($_GET['status'] == 'diedit') echo 'Berita berhasil diperbarui.';
                        if ($_GET['status'] == 'dihapus') echo 'Berita berhasil dihapus.';
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- Tabel Daftar Berita dalam Kartu Putih -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="text-left text-gray-500 uppercase text-xs">
                        <th class="px-6 py-4 font-semibold tracking-wider">Judul Berita</th>
                        <th class="px-6 py-4 font-semibold tracking-wider">Tanggal Publikasi</th>
                        <th class="px-6 py-4 font-semibold tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700">
                    <?php
                    $sql = "SELECT id, judul, tanggal_dibuat FROM berita ORDER BY tanggal_dibuat DESC";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium"><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td class="px-6 py-4"><?php echo date("d F Y", strtotime($row['tanggal_dibuat'])); ?></td>
                        <td class="px-6 py-4 text-center">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded-md text-xs transition-colors">Edit</a>
                            <a href="hapus.php?id=<?php echo $row['id']; ?>" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-md text-xs ml-2 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    } else {
                        echo '<tr><td colspan="3" class="text-center py-10 text-gray-500">Belum ada berita. Silakan klik "Tambah Berita Baru" untuk memulai.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include 'template/footer.php'; // Memuat file JavaScript ?>