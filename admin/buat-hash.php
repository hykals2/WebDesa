<?php
// Ganti ini dengan password yang ANDA INGINKAN
$password_yang_diinginkan = "kknuad123"; 

$hash = password_hash($password_yang_diinginkan, PASSWORD_DEFAULT);

echo "<h1>Hash Generator</h1>";
echo "Password yang di-hash: <strong>" . htmlspecialchars($password_yang_diinginkan) . "</strong><br><br>";
echo "Silakan SALIN (COPY) seluruh teks di bawah ini dan tempelkan ke kolom 'password' di phpMyAdmin:<br><br>";
echo "<textarea rows='3' cols='80' readonly>" . $hash . "</textarea>";
?>
```2.  Buka di browser: `http://localhost/WEBSITE-DESA/admin/buat-hash.php`