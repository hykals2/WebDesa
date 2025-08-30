<?php 
$page_title = "Manajemen Galeri";
include 'template/header.php'; 
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

        <!-- Form Upload dan Daftar Galeri dalam satu kartu -->
        <div class="bg-white shadow-lg rounded-xl p-6">
            <!-- Header Kartu -->
            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-700">Upload Foto Baru</h2>
                <!-- Form Upload -->
                <form action="tambah-galeri.php" method="post" enctype="multipart/form-data" class="flex items-center space-x-2">
                    <input type="file" name="gambar" required class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-yellow-600 cursor-pointer">
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">Upload</button>
                </form>
            </div>

            <!-- Pesan Notifikasi -->
            <?php if (isset($_GET['status'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
                    <p>
                        <?php 
                            if ($_GET['status'] == 'diupload') echo 'Foto baru berhasil diupload.';
                            if ($_GET['status'] == 'dihapus') echo 'Foto berhasil dihapus.';
                        ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Grid Galeri Foto -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <?php
                $sql = "SELECT * FROM galeri ORDER BY tanggal_upload DESC";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="relative group aspect-square">
                    <img src="/uploads/<?php echo htmlspecialchars($row['nama_file']); ?>" class="w-full h-full object-cover rounded-lg shadow-md">
                    <a href="hapus-galeri.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus foto ini?')" 
                       class="absolute top-2 right-2 bg-red-600/70 hover:bg-red-600 text-white rounded-full h-8 w-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                <?php
                    }
                } else {
                    echo "<p class='col-span-full text-center text-gray-500 py-10'>Belum ada foto di galeri. Silakan upload foto pertama Anda.</p>";
                }
                ?>
            </div>
        </div>
    </main>
</div>

<?php include 'template/footer.php'; ?>```
