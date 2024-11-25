<?php
require 'includes/db.php';  // Pastikan koneksi ke database sudah benar

// Username dan password baru
$username = 'ian';  // Gantilah dengan username yang ingin diupdate
$new_password = 'onta22';  // Gantilah dengan password baru yang ingin di-hash

// Hash password baru
$hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

// Update password di database
$sql = "UPDATE users SET password = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $hashed_password, $username);

if ($stmt->execute()) {
    echo "Password berhasil diperbarui!";
} else {
    echo "Gagal memperbarui password!";
}
?>
