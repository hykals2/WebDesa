<?php
// Menghubungkan ke database
require_once 'admin/db.php';

// Mengambil data profil dari database
$profil_sql = "SELECT * FROM profil_desa WHERE id = 1";
$profil_result = mysqli_query($conn, $profil_sql);
$profil_data = mysqli_fetch_assoc($profil_result);

// Jika tidak ada data, beri nilai default agar tidak error
if (!$profil_data) {
    $profil_data = [
        'judul' => 'Profil Desa Kliwonan', 'deskripsi' => 'Informasi profil desa belum diatur.',
        'foto' => 'default-profil.jpg', 'lokasi' => '-', 'telepon' => '-', 'email' => '-',
        'sejarah' => 'Sejarah singkat desa belum ditambahkan.',
        'visi' => 'Visi desa belum ditambahkan.', 'misi' => 'Misi desa belum ditambahkan.'
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Lengkap Desa Kliwonan</title>
    <!-- Salin semua <link> dan <script> config tailwind dari head index.php Anda ke sini -->
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
<body class="font-sans bg-gray-50">
    <!-- Header Halaman -->
    <header class="bg-primary text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
             <div class="flex flex-wrap justify-between items-center py-3">
                <a href="index.php" class="flex items-center">
                    <img src="https://picsum.photos/80?random=1" alt="Logo Desa" class="h-14 w-14 rounded-full mr-4">
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

    <!-- Konten Profil Lengkap -->
    <main class="py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">
                <img src="uploads/<?php echo htmlspecialchars($profil_data['foto']); ?>" alt="Foto Profil Desa" class="w-full h-64 object-cover rounded-lg mb-8">
                
                <h1 class="text-4xl font-bold text-gray-800 mb-6">Profil Desa Kliwonan</h1>
                
                <!-- Menggunakan kelas 'prose' dari Tailwind untuk styling otomatis -->
                <article class="prose max-w-none text-gray-700 leading-relaxed">
                    <p class="mb-6"><?php echo nl2br(htmlspecialchars($profil_data['deskripsi'])); ?></p>
                    
                    <h2 class="text-2xl font-bold mt-8 mb-4">Sejarah Singkat</h2>
                    <p><?php echo nl2br(htmlspecialchars($profil_data['sejarah'])); ?></p>
                    
                    <h2 class="text-2xl font-bold mt-8 mb-4">Visi & Misi</h2>
                    <h3 class="font-semibold">Visi</h3>
                    <p><?php echo nl2br(htmlspecialchars($profil_data['visi'])); ?></p>
                    <h3 class="font-semibold mt-4">Misi</h3>
                    <div><?php echo nl2br(htmlspecialchars($profil_data['misi'])); ?></div>
                </article>

                <div class="mt-10 border-t pt-6 text-center">
                    <a href="index.php#kontak" class="bg-primary hover:bg-secondary text-white font-bold py-2 px-6 rounded-lg transition-colors">Hubungi Kami</a>
                </div>
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
</body>
</html>