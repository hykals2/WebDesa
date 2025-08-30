<?php
// Menghubungkan ke database dan mengambil data berita
require_once '../admin/db.php';

// Memeriksa apakah ID berita ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php"); // Arahkan ke arsip jika tidak ada ID
    exit();
}

$id = $_GET['id'];

// Menggunakan prepared statement untuk keamanan
$stmt = mysqli_prepare($conn, "SELECT * FROM berita WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$berita = mysqli_fetch_assoc($result);

// Jika berita dengan ID tersebut tidak ditemukan, tampilkan pesan
if (!$berita) {
    // Kita bisa membuat halaman 404 sederhana di sini
    echo "Berita tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Judul halaman dinamis sesuai judul berita -->
    <title><?php echo htmlspecialchars($berita['judul']); ?> - Website Desa Kliwonan</title>
    
    <!-- === BAGIAN INI YANG DITAMBAHKAN UNTUK MEMPERCANTIK TAMPILAN === -->
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
    <!-- === AKHIR DARI BAGIAN YANG DITAMBAHKAN === -->

</head>
<body class="font-sans bg-gray-50">
    <!-- Header Konsisten -->
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
                <a href="../index.php" class="px-4 py-2 rounded hover:bg-secondary transition font-semibold">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content untuk Detail Artikel -->
    <main class="py-12">
        <div class="container mx-auto px-4">
            <article class="max-w-3xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-lg">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 leading-tight">
                    <?php echo htmlspecialchars($berita['judul']); ?>
                </h1>
                <div class="flex items-center text-sm text-gray-500 mb-6">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>Dipublikasikan pada <?php echo date("d F Y", strtotime($berita['tanggal_dibuat'])); ?></span>
                </div>
                <img src="../uploads/<?php echo htmlspecialchars($berita['gambar']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="w-full h-auto max-h-96 object-cover rounded-lg shadow-md mb-8">
                
                <!-- Menggunakan kelas 'prose' dari Tailwind untuk styling otomatis paragraf, list, dll. -->
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    <!-- nl2br() mengubah baris baru (\n) menjadi tag <br> agar format paragraf terjaga -->
                    <?php echo nl2br(htmlspecialchars($berita['isi'])); ?>
                </div>

                <div class="mt-10 border-t pt-6 text-center">
                    <a href="index.php" class="bg-primary hover:bg-secondary text-white font-bold py-2 px-6 rounded-lg transition-colors">&larr; Kembali ke Daftar Berita</a>
                </div>
            </article>
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
</body>
</html>