<?php
// Langkah 1: Memulai session dan memeriksa login
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke database
require_once 'db.php';

// Memeriksa apakah 'id' ada di URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$error_message = '';

// Langkah 2: Memproses form saat disubmit (method POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $gambar_lama = $_POST['gambar_lama']; // Nama gambar yang saat ini digunakan
    $gambar_baru = $_FILES['gambar']['name'];

    // Cek apakah pengguna mengupload gambar baru
    if (!empty($gambar_baru)) {
        // Jika ada gambar baru, proses upload
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        $target_file = $target_dir . basename($gambar_baru);
        
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Hapus gambar lama jika upload yang baru berhasil
            if (file_exists($target_dir . $gambar_lama)) {
                unlink($target_dir . $gambar_lama);
            }
            $nama_gambar_untuk_db = $gambar_baru;
        } else {
            $error_message = "Error: Gagal mengupload gambar baru.";
            $nama_gambar_untuk_db = $gambar_lama; // Tetap gunakan gambar lama jika upload gagal
        }
    } else {
        // Jika tidak ada gambar baru, tetap gunakan nama gambar yang lama
        $nama_gambar_untuk_db = $gambar_lama;
    }

    // Langkah 3: Update data di database
    if (empty($error_message)) {
        $stmt = mysqli_prepare($conn, "UPDATE berita SET judul = ?, isi = ?, gambar = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $judul, $isi, $nama_gambar_untuk_db, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?status=diedit"); // Arahkan kembali ke dashboard
            exit;
        } else {
            $error_message = "Error: Gagal memperbarui data di database.";
        }
    }
}


// Langkah 4: Mengambil data berita yang akan diedit untuk ditampilkan di form (method GET)
$stmt_select = mysqli_prepare($conn, "SELECT * FROM berita WHERE id = ?");
mysqli_stmt_bind_param($stmt_select, "i", $id);
mysqli_stmt_execute($stmt_select);
$result = mysqli_stmt_get_result($stmt_select);
$berita = mysqli_fetch_assoc($result);

// Jika berita dengan ID tersebut tidak ditemukan
if (!$berita) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita - Desa Kliwonan</title>
    <!-- Salin head dari admin/index.php -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { primary: "#1e40af", secondary: "#1e3a8a", accent: "#f59e0b" }, fontFamily: { sans: ['Poppins', 'sans-serif'] } } } }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-primary text-white shadow-md">
        <div class="container mx-auto px-4 flex justify-between items-center py-3">
            <h1 class="text-xl font-bold">Panel Admin - Edit Berita</h1>
            <div>
                <a href="index.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg mr-2">Batal</a>
            </div>
        </div>
    </header>
    <main class="py-10">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Berita: "<?php echo htmlspecialchars($berita['judul']); ?>"</h2>

                <?php if(!empty($error_message)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?php echo $error_message; ?></span>
                    </div>
                <?php endif; ?>

                <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label for="judul" class="block font-bold">Judul Berita</label>
                        <input id="judul" type="text" name="judul" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($berita['judul']); ?>" required>
                    </div>
                    <div>
                        <label for="isi" class="block font-bold">Isi Berita</label>
                        <textarea id="isi" name="isi" rows="10" class="w-full p-2 border rounded" required><?php echo htmlspecialchars($berita['isi']); ?></textarea>
                    </div>
                    <div>
                        <label class="block font-bold">Gambar Saat Ini</label>
                        <img src="/uploads/<?php echo htmlspecialchars($berita['gambar']); ?>" alt="Gambar saat ini" class="w-48 h-auto rounded-md border my-2">
                        <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($berita['gambar']); ?>">
                    </div>
                    <div>
                        <label for="gambar" class="block font-bold">Ganti Gambar (Opsional)</label>
                        <input id="gambar" type="file" name="gambar" class="w-full">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>