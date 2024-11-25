<?php
session_start(); // Memulai sesi untuk menyimpan data login

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'includes/db.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa username dan password
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Debugging: Tampilkan hash password yang tersimpan di database
        // echo "Stored hash: " . $user['password']; // Uncomment untuk debugging

        // Memeriksa apakah password cocok dengan hash di database
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // Menyimpan id user di sesi
            $_SESSION['username'] = $user['username']; // Menyimpan username di sesi
            header('Location: dashboard.php'); // Redirect ke halaman dashboard
            exit;
        } else {
            $error = "Username atau password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <h2>Login</h2>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>

        <p>Belum punya akun? <a href="register.php">Register</a></p>
    </form>
</body>
</html>
