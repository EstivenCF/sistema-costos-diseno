<?php
require __DIR__ . "/../config/db.php";

if (!isset($_GET['id'])) {
    die("ID no recibido");
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM trabajos WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php?page=trabajos");
exit;