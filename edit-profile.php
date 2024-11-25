<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];  // Ambil username dari session

// Proses untuk update informasi profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'includes/db.php';  // Pastikan ini terhubung dengan benar

    // Ambil data dari form
    $new_username = $_POST['username'];

    // Validasi input
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $new_username)) {
        $error = 'Username harus terdiri dari 3-20 karakter alfanumerik.';
    } else {
        // Update data di database
        $sql = "UPDATE users SET username = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $new_username, $username);
        
        if ($stmt->execute()) {
            // Update session username setelah perubahan
            $_SESSION['username'] = $new_username;
            header('Location: dashboard.php');  // Redirect ke dashboard setelah berhasil
            exit;
        } else {
            $error = 'Gagal memperbarui profil.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Edit Profile</title>
</head>
<body>
    <div class="edit-profile-container">
        <h2>Edit Profile</h2>

        <!-- Menampilkan error jika ada -->
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="edit-profile.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
            <button type="submit">Update Profile</button>
        </form>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
