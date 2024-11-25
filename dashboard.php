<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika tidak login, redirect ke halaman login
    header('Location: login.php');
    exit;
}

// Ambil nama pengguna dari session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard-container">
        <div class="welcome-message">
            <h2>Welcome to Your Dashboard, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>This is your dashboard. You are logged in as <strong><?php echo htmlspecialchars($username); ?></strong>.</p>
        </div>

        <div class="profile-section">
            <h3>Your Profile</h3>
            <p>Here you can view or update your profile information.</p>
            <a href="edit-profile.php" class="button">Edit Profile</a>
        </div>

        <div class="logout-section">
            <!-- Tombol Logout -->
            <form action="logout.php" method="POST">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
