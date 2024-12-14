<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Menangani penghapusan catatan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM notes WHERE id=$id");
    header("Location: index.php");
}

// Mengambil semua catatan dari database
$result = $conn->query("SELECT * FROM notes ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Profesional</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .navbar {
            background-color: #4a90e2;
        }
        .navbar-brand {
            color: white;
            font-weight: bold;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background-color: #4a90e2;
            border: none;
        }
        .btn-primary:hover {
            background-color: #357ABD;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fa fa-book"></i> Catatan Saya</a>
        </div>
    </nav>

    <!-- Container -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Daftar Catatan</h1>
            <a href="create.php" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Catatan</a>
        </div>

        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                            <p class="card-text text-muted"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                            <small class="text-muted">Dibuat: <?= $row['created_at'] ?></small>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</a>
                            <a href="index.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus catatan ini?')"><i class="fa fa-trash"></i> Hapus</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Catatan Profesional</a>
        <div class="d-flex">
            <span class="navbar-text me-3">
                Selamat datang, <?= $_SESSION['username'] ?>
            </span>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>


    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Catatan Saya. Dibuat dengan ❤️</p>
    </footer>
</body>
</html>
