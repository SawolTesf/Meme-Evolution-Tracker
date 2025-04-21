<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    die("⛔ Unauthorized. Only admins can delete memes.");
}

$meme_id = $_POST['id'] ?? $_GET['id'] ?? null;

if (!$meme_id) {
    die("No meme ID provided.");
}

$stmt = $conn->prepare("DELETE FROM MEME WHERE meme_id = ?");
$stmt->bind_param("i", $meme_id);

if ($stmt->execute()) {
    header("Location: review_memes.php?deleted=1");
    exit;
} else {
    echo "❌ Failed to delete meme.";
}
