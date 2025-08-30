<?php require_once '../admin/db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Berita - Website Resmi Desa Kliwonan</title>
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
</head>

<!-- PERUBAHAN 1: Tambahkan kelas flex flex-col min-h-screen -->
<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    <header class="bg-primary text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
             <div class="flex flex-wrap justify-between items-center py-3">
                <a href="../index.php" class="flex items-center">
                    <img src="https://picsum.photos/80?random=1" alt="Logo Desa" class="h-14 w-14 rounded-full mr-4">
                    <div>
                        <h1 class="text-xl font-bold">Desa Kliwonan</h1>
                        <p class="text-xs opacity-80">Kecamatan Kalibawang, Kabupaten Kulonprogo</p>
                    </div>
                </a>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <a href="../admin/login.php" class="bg-accent hover:bg-yellow-600 text-white font-bold py-2 px-3 sm:px-4 rounded-lg transition-colors text-sm">
                        <i class="fas fa-plus-circle mr-1 sm:mr-2"></i>
                        <span>Tambah Berita</span>
                    </a>
                    <a href="../index.php" class="px-3 sm:px-4 py-2 rounded hover:bg-secondary transition font-semibold text-sm">
                        &larr; <span class="hidden sm:inline">Kembali ke Beranda</span>
                    </a>
                </div>
             </div>
        </div>
    </header>

    <!-- PERUBAHAN 2: Tambahkan kelas flex-grow -->
    <main class="py-12 flex-grow">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12"><h1 class="text-3xl font-bold text-gray-800 mb-2">Arsip Berita Desa</h1><div class="w-20 h-1 bg-accent mx-auto"></div></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $sql = "SELECT * FROM berita ORDER BY tanggal_dibuat DESC";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="bg-white rounded-lg overflow-hidden shadow-md group">
                    <img src="/WEBSITE-DESA/uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['judul']); ?>" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 mb-2"><?php echo date("d F Y", strtotime($row['tanggal_dibuat'])); ?></p>
                        <h3 class="text-xl font-bold text-gray-800 mb-3"><?php echo htmlspecialchars($row['judul']); ?></h3>
                        <a href="detail.php?id=<?php echo $row['id']; ?>" class="font-bold text-primary hover:text-secondary">Baca Selengkapnya &rarr;</a>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p class='col-span-3 text-center text-gray-500'>Belum ada berita. Silakan tambahkan berita baru.</p>";
                }
                ?>
            </div>
        </div>
    </main>
       <!-- Footer -->
    <footer class="bg-secondary text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?php echo date("Y"); ?> Pemerintah Desa Kliwonan. Semua Hak Cipta Dilindungi.</p>

            <!-- === BAGIAN BARU DITAMBAHKAN DI SINI === -->
            <p class="text-sm opacity-80 mt-2">
                Supported by KKN Reguler 121 IA2 UAD - 
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
</html>