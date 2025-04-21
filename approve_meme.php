<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if (!$id) {
        die("No meme ID provided.");
    }

    $stmt = $conn->prepare("SELECT first_appearance FROM MEME WHERE meme_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($first_appearance);
    $stmt->fetch();
    $stmt->close();

    if (!$first_appearance || strtotime($first_appearance) < strtotime('2000-01-01')) {
        echo "<script>alert('⛔ Cannot approve meme. First appearance must be after year 2000.'); window.location.href='review_memes.php';</script>";
        exit;
    }

    // Approve it
    $approve = $conn->prepare("UPDATE MEME SET is_approved = 1 WHERE meme_id = ?");
    $approve->bind_param("i", $id);
    $approve->execute();

    header("Location: review_memes.php");
    exit;
}
?>
