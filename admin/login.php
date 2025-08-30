<?php
session_start();
// Jika pengguna sudah login, langsung arahkan ke dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit;
}

require_once 'db.php'; 
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan username dan password tidak kosong
    if (empty(trim($_POST["username"])) || empty(trim($_POST["password"]))) {
        $error = 'Harap masukkan username dan password.';
    } else {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Siapkan query SELECT
        $sql = "SELECT id, username, password, nama_lengkap FROM users WHERE username = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            
            if (mysqli_stmt_execute($stmt)) {
                // Simpan hasil query
                mysqli_stmt_store_result($stmt);
                
                // Cek apakah username ditemukan (ada 1 baris hasil)
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // === INI BAGIAN PERBAIKAN UTAMA ===
                    // Ikat variabel hasil ke variabel PHP
                    mysqli_stmt_bind_result($stmt, $id, $db_username, $hashed_password, $nama_lengkap);
                    
                    if (mysqli_stmt_fetch($stmt)) {
                        // Verifikasi password
                        if (password_verify($password, $hashed_password)) {
                            // Password benar, mulai session baru
                            session_regenerate_id();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id;
                            $_SESSION["username"] = $db_username;
                            $_SESSION["nama_lengkap"] = $nama_lengkap;
                            
                            // Arahkan ke dashboard
                            header("location: index.php");
                            exit;
                        } else {
                            // Password salah
                            $error = 'Username atau password yang Anda masukkan salah.';
                        }
                    }
                } else {
                    // Username tidak ditemukan
                    $error = 'Username atau password yang Anda masukkan salah.';
                }
            } else {
                echo "Terjadi kesalahan. Silakan coba lagi nanti.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Desa Kliwonan</title>
    <!-- Salin head dari halaman lain yang sudah benar -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { primary: "#1e40af", secondary: "#1e3a8a", accent: "#f59e0b" }, fontFamily: { sans: ['Poppins', 'sans-serif'] } } }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen font-sans">
    <div class="w-full max-w-sm">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Login Panel Admin</h1>
                <p class="text-gray-500 text-sm mt-1">Desa Kliwonan</p>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-bold mb-2">Username</label>
                    <input type="text" name="username" id="username" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <div class="mb-5">
                    <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <?php if(!empty($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm" role="alert">
                        <span class="block sm:inline"><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>
                <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">Masuk</button>
            </form>
        </div>
        <div class="text-center mt-4">
             <a href="../index.php" class="text-sm text-primary hover:underline">&larr; Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>