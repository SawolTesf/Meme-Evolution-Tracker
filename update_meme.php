<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    die("Access denied.");
}

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? '';
$origin = $_POST['origin_platform'] ?? '';
$date = $_POST['first_appearance'] ?? '';
$desc = $_POST['description'] ?? '';

if (!$id || !$name || !$desc) {
    die("Missing required fields.");
}

$stmt = $conn->prepare("UPDATE MEME SET name = ?, origin_platform = ?, first_appearance = ?, description = ? WHERE meme_id = ?");
$stmt->bind_param("ssssi", $name, $origin, $date, $desc, $id);
$stmt->execute();

header("Location: moderate.php?id=$id&updated=1");
exit;
