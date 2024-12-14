<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $reminder_time = $_POST['reminder_time'] ?: null;

    $conn->query("INSERT INTO notes (title, content, reminder_time) VALUES ('$title', '$content', '$reminder_time')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .btn-primary {
            background-color: #4a90e2;
            border: none;
        }
        .btn-primary:hover {
            background-color: #357ABD;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="h3 text-center mb-4">Tambah Catatan Baru</h1>
        <form action="create.php" method="post" class="bg-white p-4 rounded shadow">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Catatan</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan judul..." required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Isi Catatan</label>
                <textarea id="content" name="content" class="form-control" rows="5" placeholder="Tuliskan isi catatan..." required></textarea>
            </div>
            <div class="mb-3">
                <label for="reminder_time" class="form-label">Setel Pengingat</label>
                <input type="datetime-local" id="reminder_time" name="reminder_time" class="form-control">
            </div>
            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>