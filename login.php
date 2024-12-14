<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query pengguna berdasarkan username
    $result = $conn->query("SELECT * FROM users WHERE username = '$username'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Pengguna tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Login</h1>
        <form method="post" class="shadow p-4 rounded bg-white mx-auto" style="max-width: 400px;">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>