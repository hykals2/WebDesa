<?php 
$page_title = "Dashboard";
include 'template/header.php'; 
include 'template/sidebar.php'; 

// PHP untuk mengambil data statistik (sama seperti sebelumnya)
$count_result = mysqli_query($conn, "SELECT COUNT(id) AS total FROM berita");
$total_berita = mysqli_fetch_assoc($count_result)['total'];
$gallery_count_result = mysqli_query($conn, "SELECT COUNT(id) AS total FROM galeri");
$total_galeri = mysqli_fetch_assoc($gallery_count_result)['total'];
$latest_result = mysqli_query($conn, "SELECT judul FROM berita ORDER BY tanggal_dibuat DESC LIMIT 1");
$berita_terbaru = (mysqli_num_rows($latest_result) > 0) ? mysqli_fetch_assoc($latest_result)['judul'] : 'Belum ada berita';
?>

<!-- Kontainer Utama Konten -->
<div class="flex-1 flex flex-col">
    <!-- Header Konten (dengan tombol hamburger) -->
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <!-- Tombol Hamburger (Hanya Tampil di Mobile) -->
        <button id="sidebar-toggle" class="text-gray-600 hover:text-primary lg:hidden">
            <i class="fas fa-bars fa-lg"></i>
        </button>
        <!-- Judul Halaman -->
        <h1 class="text-lg font-semibold text-gray-800"><?php echo $page_title; ?></h1>
        <!-- Tombol Logout -->
        <a href="logout.php" class="text-gray-600 hover:text-primary text-sm"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
    </header>

    <!-- Area Konten Utama Halaman -->
    <main class="flex-1 p-6 md:p-10">
        <h1 class="text-3xl font-bold mb-2 text-gray-800">Selamat Datang, Admin!</h1>
        <p class="text-gray-500 mb-8">Ini adalah pusat kontrol untuk website Desa Kliwonan.</p>

        <!-- Bagian Statistik -->
        <section id="statistik" class="mb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Kartu Total Berita -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full"><i class="fas fa-newspaper fa-2x text-primary"></i></div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Berita</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo $total_berita; ?> Artikel</p>
                    </div>
                </div>
                <!-- Kartu Total Foto Galeri -->
                <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4">
                    <div class="bg-purple-100 p-3 rounded-full"><i class="fas fa-images fa-2x text-purple-600"></i></div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Foto Galeri</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo $total_galeri; ?> Foto</p>
                    </div>
                </div>
                 <!-- Kartu Berita Terbaru -->
                 <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4 overflow-hidden">
                    <div class="bg-green-100 p-3 rounded-full flex-shrink-0"><i class="fas fa-clock fa-2x text-green-600"></i></div>
                    <div class="min-w-0">
                        <p class="text-gray-500 text-sm">Berita Terbaru</p>
                        <p class="text-xl font-bold text-gray-800 truncate"><?php echo htmlspecialchars($berita_terbaru); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pintasan Cepat -->
        <section>
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Akses Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="berita.php" class="bg-white hover:bg-blue-50 p-6 rounded-xl shadow-lg text-center transition-colors">
                    <i class="fas fa-newspaper fa-3x text-primary"></i>
                    <h3 class="font-bold text-xl mt-4 text-gray-800">Kelola Berita</h3>
                </a>
                <a href="galeri.php" class="bg-white hover:bg-purple-50 p-6 rounded-xl shadow-lg text-center transition-colors">
                    <i class="fas fa-images fa-3x text-purple-600"></i>
                    <h3 class="font-bold text-xl mt-4 text-gray-800">Kelola Galeri</h3>
                </a>
                <a href="struktur.php" class="bg-white hover:bg-green-50 p-6 rounded-xl shadow-lg text-center transition-colors">
                    <i class="fas fa-sitemap fa-3x text-green-600"></i>
                    <h3 class="font-bold text-xl mt-4 text-gray-800">Edit Struktur Desa</h3>
                </a>
            </div>
        </section>
    </main>
</div>

<?php include 'template/footer.php'; // Memuat file JavaScript ?>