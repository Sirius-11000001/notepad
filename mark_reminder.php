<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("UPDATE notes SET reminder_time = NULL WHERE id=$id");
}
?>