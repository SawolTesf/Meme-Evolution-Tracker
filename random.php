<?php
require 'db.php';

$result = $conn->query("SELECT meme_id FROM MEME ORDER BY RAND() LIMIT 1");

if ($row = $result->fetch_assoc()) {
    $random_id = $row['meme_id'];
    header("Location: meme.php?id=" . $random_id);
    exit;
} else {
    echo "No memes found.";
}
?>
