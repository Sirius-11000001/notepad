<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Mendapatkan catatan berdasarkan ID
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM notes WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$note = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (!empty($title) && strlen($title) <= 255 && !empty($content)) {
        $stmt = $conn->prepare("UPDATE notes SET title=?, content=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $content, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?updated=true");
        exit();
    } else {
        $error = "Judul harus diisi dan tidak lebih dari 255 karakter. Isi catatan tidak boleh kosong.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
    <div class="container">
        <h1 class="my-4 text-center">Edit Catatan</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="edit.php?id=<?= $id ?>" method="post" class="shadow p-4 rounded bg-light">
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" id="title" name="title" class="form-control" 
                       value="<?= htmlspecialchars($note['title']) ?>" placeholder="Masukkan judul catatan Anda..." required>
                <small class="form-text text-muted">Judul tidak boleh lebih dari 255 karakter.</small>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Isi Catatan</label>
                <textarea id="content" name="content" class="form-control" rows="5" required><?= htmlspecialchars($note['content']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2" onclick="return confirm('Apakah Anda yakin ingin membatalkan perubahan?')">Batal</a>
        </form>
    </div>
</body>
</html>