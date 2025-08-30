<!-- Overlay untuk latar belakang saat sidebar mobile terbuka -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-primary text-white min-h-screen p-4 flex flex-col fixed inset-y-0 left-0
           transform -translate-x-full lg:relative lg:translate-x-0 
           transition-transform duration-300 ease-in-out z-30">
    
    <!-- ============================================= -->
    <!-- == BAGIAN INI YANG DISESUAIKAN == -->
    <!-- ============================================= -->
    <div class="flex items-center space-x-3 mb-10">
        <!-- Menggunakan ikon user generik -->
        <div class="w-12 h-12 rounded-full border-2 border-blue-300 bg-secondary flex items-center justify-center flex-shrink-0">
            <i class="fas fa-user fa-lg text-white"></i>
        </div>
        <div>
            <!-- Menampilkan nama_lengkap dari session -->
            <h1 class="text-lg font-bold text-white truncate" title="<?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?>">
                <?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?>
            </h1>
            <p class="text-xs text-blue-200">Administrator</p>
        </div>
    </div>
    
    <!-- Menu Navigasi -->
    <nav class="flex-grow">
        <a href="index.php" class="flex items-center space-x-3 text-blue-100 hover:bg-secondary hover:text-white p-2 rounded-lg transition-colors">
            <i class="fas fa-tachometer-alt fa-fw"></i><span>Dashboard</span>
        </a>
        <a href="berita.php" class="flex items-center space-x-3 text-blue-100 hover:bg-secondary hover:text-white p-2 mt-2 rounded-lg transition-colors">
            <i class="fas fa-newspaper fa-fw"></i><span>Manajemen Berita</span>
        </a>
        <a href="galeri.php" class="flex items-center space-x-3 text-blue-100 hover:bg-secondary hover:text-white p-2 mt-2 rounded-lg transition-colors">
            <i class="fas fa-images fa-fw"></i><span>Manajemen Galeri</span>
        </a>
        <a href="struktur.php" class="flex items-center space-x-3 text-blue-100 hover:bg-secondary hover:text-white p-2 mt-2 rounded-lg transition-colors">
            <i class="fas fa-sitemap fa-fw"></i><span>Struktur Desa</span>
        </a>
        <a href="profil.php" class="flex items-center space-x-3 text-blue-100 hover:bg-secondary hover:text-white p-2 mt-2 rounded-lg transition-colors">
            <i class="fas fa-id-card fa-fw"></i><span>Edit Profil Desa</span>
        </a>
        <a href="data-desa.php" class="flex items-center space-x-3 text-blue-100 hover:bg-secondary hover:text-white p-2 mt-2 rounded-lg transition-colors">
            <i class="fas fa-chart-bar fa-fw"></i><span>Edit Data Desa</span>
        </a>    
    </nav>
    
    <!-- Tombol Logout -->
    <div>
        <a href="logout.php" class="flex items-center space-x-3 text-blue-100 hover:bg-red-600 hover:text-white p-2 rounded-lg transition-colors">
            <i class="fas fa-sign-out-alt fa-fw"></i><span>Logout</span>
        </a>
    </div>
</aside>