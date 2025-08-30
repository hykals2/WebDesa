<?php
// Menghubungkan ke database
require_once 'admin/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Lengkap - Desa Kliwonan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: "#1e40af", secondary: "#1e3a8a", accent: "#f59e0b" },
                    fontFamily: { sans: ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<!-- PERUBAHAN 1: Tambahkan kelas flex flex-col min-h-screen -->
<body class="font-sans bg-gray-50 flex flex-col min-h-screen">
    <!-- Header Halaman -->
    <header class="bg-primary text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
             <div class="flex flex-wrap justify-between items-center py-3">
                <a href="index.php" class="flex items-center">
                    <div>
                        <h1 class="text-xl font-bold">Desa Kliwonan</h1>
                        <p class="text-xs opacity-80">Kecamatan Kalibawang, Kabupaten Kulonprogo</p>
                    </div>
                </a>
                <a href="index.php" class="px-4 py-2 rounded hover:bg-secondary transition font-semibold">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </header>

    <!-- PERUBAHAN 2: Tambahkan kelas flex-grow -->
    <main class="py-12 flex-grow">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Galeri Lengkap Desa Kliwonan</h1>
                <div class="w-20 h-1 bg-accent mx-auto"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php
                // Mengambil SEMUA foto dari database, tanpa LIMIT
                $galeri_sql = "SELECT * FROM galeri ORDER BY tanggal_upload DESC";
                $galeri_result = mysqli_query($conn, $galeri_sql);
                
                if (mysqli_num_rows($galeri_result) > 0) {
                    while($row = mysqli_fetch_assoc($galeri_result)):
                ?>
                <div class="overflow-hidden rounded-lg shadow-md group aspect-square">
                    <img src="uploads/<?php echo htmlspecialchars($row['nama_file']); ?>" alt="Galeri Desa Kliwonan" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <?php 
                    endwhile;
                } else {
                    // Pesan jika tidak ada foto di galeri
                    echo "<p class='col-span-full text-center text-gray-500 py-10'>Belum ada foto di galeri.</p>";
                }
                ?>
            </div>
        </div>
    </main>

    <!-- Footer Halaman -->
    <footer class="bg-secondary text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?php echo date("Y"); ?> Pemerintah Desa Kliwonan. Semua Hak Cipta Dilindungi.</p>
            <p class="text-sm opacity-80 mt-2">
                Supported by KKN Reguler 121 IA2 UAD - 
                <a href="https://uad.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-accent font-semibold">Universitas Ahmad Dahlan</a>
            </p>
        </div>
    </footer>
</body>
</html>