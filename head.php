<?php
require 'db.php';

// Mengambil semua catatan dengan waktu pengingat
$result = $conn->query("SELECT * FROM notes ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Profesional</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if ("Notification" in window) {
                // Meminta izin notifikasi
                if (Notification.permission !== "granted") {
                    Notification.requestPermission();
                }

                // Cek catatan dengan waktu pengingat
                const reminders = <?= json_encode($conn->query("SELECT id, title, reminder_time FROM notes WHERE reminder_time IS NOT NULL")->fetch_all(MYSQLI_ASSOC)); ?>;

                reminders.forEach(reminder => {
                    const reminderTime = new Date(reminder.reminder_time).getTime();
                    const now = new Date().getTime();

                    if (reminderTime <= now) {
                        // Menampilkan notifikasi jika pengingat tercapai
                        new Notification("Pengingat Catatan!", {
                            body: `Catatan "${reminder.title}" membutuhkan perhatianmu.`,
                            icon: "https://cdn-icons-png.flaticon.com/512/1159/1159633.png"
                        });

                        // Optional: Tandai pengingat sudah ditampilkan di backend
                        fetch(`mark_reminder.php?id=${reminder.id}`);
                    }
                });
            }
        });
    </script>
</head>
<body>
<!-- Konten lainnya sama seperti sebelumnya -->
</body>
</html>
