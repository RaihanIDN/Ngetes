<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'includes/db.php';  // Pastikan ini terhubung dengan benar

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $error = 'Username harus terdiri dari 3-20 karakter alfanumerik.';
    } elseif (strlen($password) < 6) {
        $error = 'Password harus memiliki minimal 6 karakter.';
    } elseif ($password !== $confirm_password) {
        $error = 'Password tidak cocok.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Gunakan PASSWORD_DEFAULT

        // Pastikan username unik
        $sql_check = "SELECT * FROM users WHERE username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param('s', $username);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $error = "Username sudah terdaftar.";
        } else {
            // Simpan pengguna baru
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $hashed_password);

            if ($stmt->execute()) {
                header('Location: login.php?success=1', true, 303);
                exit;
            } else {
                $error = 'Gagal mendaftarkan pengguna.';
            }
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
    <title>Register</title>
</head>
<body>
    <form action="register.php" method="POST">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>

    <script src="assets/js/script.js"></script>
</body>
</html>
