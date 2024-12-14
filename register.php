<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    // Masukkan data user ke tabel users
    $result = $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
    if ($result) {
        header('Location: login.php'); // Arahkan ke halaman login
        exit;
    } else {
        $error = "Gagal mendaftarkan pengguna! Username mungkin sudah digunakan.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registrasi</h1>
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
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
    </div>
</body>
</html>