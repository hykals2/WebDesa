<?php
// Langkah 1: Menghubungkan ke database. File ini harus ada di paling atas.
require_once 'admin/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <base target="_self">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Resmi Desa Kliwonan</title>
    <meta name="description" content="Website resmi Desa Kliwonan dengan berbagai informasi dan layanan publik">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#1e40af",
                        secondary: "#1e3a8a",
                        accent: "#f59e0b"
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Menambahkan efek scroll yang mulus */
        html {
            scroll-behavior: smooth;
        }
        /* Style untuk navigasi aktif */
        .nav-link.active {
            background-color: #f59e0b;
            color: white;
        }
        .nav-link {
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.3s, color 0.3s;
        }
        .nav-link:hover {
            background-color: #002aff;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <!-- Header -->
    <header class="bg-primary text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between items-center py-3">

                <!-- Bagian Kiri: Logo dan Judul -->
                <div class="flex items-center">

                    <div>
                        <h1 class="text-xl font-bold">Desa Kliwonan</h1>
                        <p class="text-xs opacity-80">Kecamatan Kalibawang, Kabupaten Kulonprogo</p>
                    </div>
                </div>

                <!-- Bagian Kanan: Navigasi Desktop dan Ikon -->
                <div class="flex items-center space-x-4">
                    <!-- Navigasi untuk Desktop -->
                    <nav class="hidden lg:flex">
                        <ul class="flex space-x-1">
                            <li><a href="#beranda" class="nav-link active">Beranda</a></li>
                            <li><a href="#profil" class="nav-link">Profil Desa</a></li>
                            <li><a href="#struktur" class="nav-link">Struktur Desa</a></li>
                            <li><a href="#peta" class="nav-link">Peta Desa</a></li>
                            <li><a href="#berita" class="nav-link">Berita</a></li>
                            <li><a href="#galeri" class="nav-link">Galeri</a></li>
                            <li><a href="#layanan" class="nav-link">Layanan</a></li>
                            <li><a href="#kontak" class="nav-link">Kontak</a></li>
                        </ul>
                    </nav>

                    <!-- Ikon Pencarian dan Tombol Menu Mobile -->
                    <div class="flex items-center space-x-2">
                         <a href="#" class="px-3 py-2 rounded hover:bg-secondary transition" onclick="event.preventDefault(); alert('Fitur pencarian akan datang!')">
                            <i class="fas fa-search"></i>
                        </a>
                        <button id="mobile-menu-button" class="lg:hidden px-3 py-2 rounded hover:bg-secondary transition">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Navigasi untuk Mobile (muncul di bawah) -->
            <nav id="mobile-menu" class="hidden lg:hidden pb-4">
                <ul class="flex flex-col space-y-2">
                    <li><a href="#beranda" class="block px-4 py-2 hover:bg-secondary rounded">Beranda</a></li>
                    <li><a href="#profil" class="block px-4 py-2 hover:bg-secondary rounded">Profil Desa</a></li>
                    <li><a href="#struktur" class="block px-4 py-2 hover:bg-secondary rounded">Struktur Desa</a></li>
                    <li><a href="#peta" class="block px-4 py-2 hover:bg-secondary rounded">Peta Desa</a></li>
                    <li><a href="#berita" class="block px-4 py-2 hover:bg-secondary rounded">Berita</a></li>
                    <li><a href="#galeri" class="block px-4 py-2 hover:bg-secondary rounded">Galeri</a></li>
                    <li><a href="#layanan" class="block px-4 py-2 hover:bg-secondary rounded">Layanan</a></li>
                    <li><a href="#kontak" class="block px-4 py-2 hover:bg-secondary rounded">Kontak</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
 <section id="beranda" class="relative relative h-[85vh] flex items-center justify-center text-white bg-cover bg-center" style="background-image:url('/WEBSITE-DESA/assets/d.jpg');">
            <!-- Lapisan Warna Biru Transparan -->
            <div class="absolute inset-0 bg-primary opacity-60"></div>

            <!-- Konten Teks di Atas Lapisan -->
            <div class="relative z-10 container mx-auto px-4 text-center">
                <h2 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">
                    Selamat Datang di Website Resmi<br>Desa Kliwonan
                </h2>
                <p class="text-lg md:text-xl mb-8 max-w-3xl mx-auto">
                    Portal informasi dan layanan publik untuk seluruh warga Desa Kliwonan.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="#layanan" class="bg-accent hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-lg transition-transform hover:scale-105">
                        Layanan Desa
                    </a>
                    <a href="#berita" class="bg-white hover:bg-gray-200 text-primary font-bold py-3 px-8 rounded-lg transition-transform hover:scale-105">
                        Berita Terkini
                    </a>
                </div>
            </div>
        </section>

<section class="bg-white py-8 shadow-sm">
            <div class="container mx-auto px-4">
                <?php
                // Mengambil data info desa dari database
                $info_sql = "SELECT * FROM info_desa WHERE id = 1";
                $info_result = mysqli_query($conn, $info_sql);
                $info_data = mysqli_fetch_assoc($info_result);
                
                if ($info_data) {
                ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Jumlah Penduduk -->
                    <div class="bg-gray-50 hover:bg-gray-100 p-6 rounded-xl text-center transition-colors">
                        <div class="text-primary text-4xl mb-2"><i class="fas fa-users"></i></div>
                        <h3 class="font-bold text-lg mb-1">Jumlah Penduduk</h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($info_data['jumlah_penduduk']); ?></p>
                    </div>
                    <!-- Jumlah KK -->
                    <div class="bg-gray-50 hover:bg-gray-100 p-6 rounded-xl text-center transition-colors">
                        <div class="text-primary text-4xl mb-2"><i class="fas fa-home"></i></div>
                        <h3 class="font-bold text-lg mb-1">Jumlah KK</h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($info_data['jumlah_kk']); ?></p>
                    </div>
                    <!-- Luas Wilayah -->
                    <div class="bg-gray-50 hover:bg-gray-100 p-6 rounded-xl text-center transition-colors">
                        <div class="text-primary text-4xl mb-2"><i class="fas fa-map-marked-alt"></i></div>
                        <h3 class="font-bold text-lg mb-1">Luas Wilayah</h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($info_data['luas_wilayah']); ?></p>
                    </div>
                    <!-- Hari Jadi -->
                    <div class="bg-gray-50 hover:bg-gray-100 p-6 rounded-xl text-center transition-colors">
                        <div class="text-primary text-4xl mb-2"><i class="fas fa-calendar-alt"></i></div>
                        <h3 class="font-bold text-lg mb-1">Hari Jadi</h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($info_data['hari_jadi']); ?></p>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </section>

        <!-- ============================================= -->
        <!-- == BAGIAN PROFIL DESA (DINAMIS) == -->
        <!-- ============================================= -->
        <section id="profil" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Profil Desa</h2>
                    <div class="w-20 h-1 bg-accent mx-auto"></div>
                </div>
                <?php
                // Mengambil data profil dari database
                $profil_sql = "SELECT * FROM profil_desa WHERE id = 1";
                $profil_result = mysqli_query($conn, $profil_sql);
                $profil_data = mysqli_fetch_assoc($profil_result);
                
                // Pastikan ada data sebelum menampilkannya
                if ($profil_data) {
                ?>
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                        <img src="/uploads/<?php echo htmlspecialchars($profil_data['foto']); ?>" alt="Foto Profil Desa Kliwonan" class="w-full rounded-lg shadow-md">
                    </div>
                    <div class="md:w-1/2">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Desa Kliwonan</h3>
                        <p class="text-gray-600 mb-4">
                            <?php echo nl2br(htmlspecialchars($profil_data['deskripsi'])); ?>
                        </p>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="text-accent mr-3 mt-1"><i class="fas fa-map-marker-alt"></i></div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Lokasi</h4>
                                    <p class="text-gray-600"><?php echo htmlspecialchars($profil_data['lokasi']); ?></p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="text-accent mr-3 mt-1"><i class="fas fa-phone-alt"></i></div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Telepon</h4>
                                    <p class="text-gray-600"><?php echo htmlspecialchars($profil_data['telepon']); ?></p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="text-accent mr-3 mt-1"><i class="fas fa-envelope"></i></div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Email</h4>
                                    <p class="text-gray-600"><?php echo htmlspecialchars($profil_data['email']); ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- Tombol ini bisa dihubungkan ke halaman lain jika ada -->
                        <a href="profil-lengkap.php" class="inline-block mt-6 bg-primary hover:bg-secondary text-white font-bold py-2 px-6 rounded-lg transition">Selengkapnya</a>
                    </div>
                </div>
                <?php 
                } else {
                    echo "<p class='text-center text-gray-500'>Informasi profil desa belum tersedia.</p>";
                }
                ?>
            </div>
        </section>

        <!-- ============================================= -->
        <!-- == STRUKTUR DESA (DESAIN HIERARKIS - DIPERBAIKI) == -->
        <!-- ============================================= -->
        <section id="struktur" class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Struktur Organisasi Desa</h2>
                    <div class="w-20 h-1 bg-accent mx-auto"></div>
                </div>
                <?php
                // Mengambil data dari database
                $struktur_sql = "SELECT * FROM struktur_desa ORDER BY id ASC";
                $struktur_result = mysqli_query($conn, $struktur_sql);
                $perangkat_desa = [];
                while($row = mysqli_fetch_assoc($struktur_result)) {
                    $perangkat_desa[] = $row;
                }
                
                if (!empty($perangkat_desa)) {
                ?>
                <!-- Baris Kepala Desa -->
                <div class="flex justify-center mb-10">
                    <div class="text-center">
                        <img src="/uploads/<?php echo htmlspecialchars($perangkat_desa[0]['foto']); ?>" alt="<?php echo htmlspecialchars($perangkat_desa[0]['jabatan']); ?>" class="w-40 h-40 rounded-full mx-auto mb-4 shadow-lg object-cover border-4 border-accent">
                        <h3 class="text-2xl font-bold text-gray-800"><?php echo htmlspecialchars($perangkat_desa[0]['nama']); ?></h3>
                        <p class="text-accent font-semibold text-lg"><?php echo htmlspecialchars($perangkat_desa[0]['jabatan']); ?></p>
                    </div>
                </div>
                
                <!-- Baris Perangkat Desa Lainnya -->
                <div class="flex flex-wrap justify-center gap-y-10 gap-x-8">
                    <?php for($i = 1; $i < count($perangkat_desa); $i++): ?>
                    <div class="text-center w-full sm:w-1/3 lg:w-1/4">
                        <img src="uploads/<?php echo htmlspecialchars($perangkat_desa[$i]['foto']); ?>" alt="<?php echo htmlspecialchars($perangkat_desa[$i]['jabatan']); ?>" class="w-32 h-32 rounded-full mx-auto mb-4 shadow-lg object-cover">
                        <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($perangkat_desa[$i]['nama']); ?></h3>
                        <p class="text-gray-500 font-medium mt-1"><?php echo htmlspecialchars($perangkat_desa[$i]['jabatan']); ?></p>
                    </div>
                    <?php endfor; ?>
                </div>
                <?php 
                } else {
                    echo "<p class='text-center text-gray-500'>Data struktur desa belum diatur.</p>";
                }
                ?>
            </div>
        </section>

        <!-- ============================================= -->
        <!-- == BAGIAN PETA DESA (STATIS) == -->
        <!-- ============================================= -->
        <section id="peta" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Peta Wilayah Desa</h2>
                    <div class="w-20 h-1 bg-accent mx-auto"></div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-lg">
                     <!-- Ganti SRC dengan link embed Google Maps desa Anda -->
                    <iframe 
                        < src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253059.88716624622!2d109.96473173281251!3d-7.676619900000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7af487a8ad058b%3A0x90bf0ecdc35fc8f5!2sMushola%20Darusalam%20Padaan%20Kliwonan!5e0!3m2!1sid!2sid!4v1756379456962!5m2!1sid!2sid"
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </section>

        <!-- ============================================= -->
        <!-- == BAGIAN BERITA (DINAMIS) == -->
        <!-- ============================================= -->
        <section id="berita" class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Berita Terkini</h2>
                    <div class="w-20 h-1 bg-accent mx-auto"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    // Ambil 3 berita terbaru dari database
                    $sql = "SELECT * FROM berita ORDER BY tanggal_dibuat DESC LIMIT 3";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // Loop melalui setiap berita dan tampilkan
                        while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- Template Kartu Berita -->
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md group">
                        <!-- Gambar dinamis dari folder uploads -->
                        <img src="/uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="p-6">
                            <!-- Tanggal dinamis -->
                            <p class="text-sm text-gray-500 mb-2"><?php echo date("d F Y", strtotime($row['tanggal_dibuat'])); ?></p>
                            <!-- Judul dinamis -->
                            <h3 class="text-xl font-bold text-gray-800 mb-3"><?php echo htmlspecialchars($row['judul']); ?></h3>
                            <!-- Isi dinamis (dipotong agar tidak terlalu panjang) -->
                            <p class="text-gray-600 mb-4 text-sm"><?php echo substr(htmlspecialchars($row['isi']), 0, 100); ?>...</p>
                            <!-- Tautan dinamis ke halaman detail -->
                            <a href="berita/detail.php?id=<?php echo $row['id']; ?>" class="font-bold text-primary hover:text-secondary">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        // Pesan jika tidak ada berita sama sekali
                        echo "<p class='col-span-3 text-center text-gray-500'>Belum ada berita yang dipublikasikan.</p>";
                    }
                    ?>
                </div>
               
                <!-- Tombol Lihat Semua Berita -->
                <div class="text-center mt-12">
                    <!-- Tautan mengarah ke berita/index.php -->
                    <a href="berita/index.php" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-8 rounded-lg transition-colors duration-300">
                        Lihat Semua Berita
                    </a>
                </div>
            </div>
        </section>

          <!-- ============================================= -->
        <!-- == BAGIAN GALERI (DINAMIS DENGAN TOMBOL) == -->
        <!-- ============================================= -->
        <section id="galeri" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Galeri Desa</h2>
                    <div class="w-20 h-1 bg-accent mx-auto"></div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <?php
                    // Mengambil 8 foto terbaru dari database untuk pratinjau
                    $galeri_sql = "SELECT * FROM galeri ORDER BY tanggal_upload DESC LIMIT 8";
                    $galeri_result = mysqli_query($conn, $galeri_sql);
                    
                    if (mysqli_num_rows($galeri_result) > 0) {
                        while($row = mysqli_fetch_assoc($galeri_result)):
                    ?>
                    <div class="overflow-hidden rounded-lg shadow-md group">
                        <img src="/uploads/<?php echo htmlspecialchars($row['nama_file']); ?>" alt="Galeri Desa Kliwonan" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <?php 
                        endwhile;
                    } else {
                        // Pesan jika tidak ada foto di galeri
                        echo "<p class='col-span-full text-center text-gray-500'>Belum ada foto di galeri.</p>";
                    }
                    ?>
                </div>

                <!-- === TOMBOL BARU DITAMBAHKAN DI SINI === -->
                <div class="text-center mt-12">
                    <a href="galeri-lengkap.php" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-8 rounded-lg transition-colors duration-300">
                        Lihat Semua Galeri
                    </a>
                </div>
                <!-- === AKHIR DARI TOMBOL BARU === -->

            </div>
        </section>
        <!-- Placeholder untuk Layanan -->
        <section id="layanan" class="py-16 bg-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Layanan Desa</h2>
                <div class="w-20 h-1 bg-accent mx-auto"></div>
                <p class="text-gray-600 mt-4">Informasi mengenai layanan desa akan ditampilkan di sini.</p>
            </div>
        </section>

        <!-- Placeholder untuk Kontak -->
        <section id="kontak" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Kontak Kami</h2>
                <div class="w-20 h-1 bg-accent mx-auto"></div>
                <p class="text-gray-600 mt-4">Informasi kontak dan formulir akan ditampilkan di sini.</p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-secondary text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?php echo date("Y"); ?> Pemerintah Desa Kliwonan. Semua Hak Cipta Dilindungi.</p>

            <!-- === BAGIAN BARU DITAMBAHKAN DI SINI === -->
            <p class="text-sm opacity-80 mt-2">
                Supported by KKN Reguler 145 IA2 UAD - 
                <a href="https://uad.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-accent font-semibold">Universitas Ahmad Dahlan</a>
            </p>
            <!-- === AKHIR DARI BAGIAN BARU === -->

            <div class="flex justify-center space-x-4 mt-4">
                <a href="#" class="hover:text-accent"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-accent"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-accent"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-accent"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </footer>

    <script>
        // JavaScript untuk toggle menu mobile
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // JavaScript untuk menandai navigasi aktif saat scroll
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 150) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>