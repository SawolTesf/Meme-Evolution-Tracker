<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    die("Access denied.");
}

$id = $_GET['id'] ?? null;
if (!$id) die("No meme ID specified.");

// Fetch the meme
$stmt = $conn->prepare("SELECT * FROM MEME WHERE meme_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$meme = $result->fetch_assoc();
if (!$meme) die("Meme not found.");

$link_stmt = $conn->prepare("SELECT link, description FROM MEME_REFERENCE_LINK WHERE meme_id = ?");
$link_stmt->bind_param("i", $id);
$link_stmt->execute();
$reference_links = $link_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Meme – Meme Wiki</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
            color: #f5f5f5;
            margin: 0;
            padding-top: 5rem;
        }

        .content-wrapper {
            max-width: 850px;
            margin: auto;
            padding: 2rem;
        }

        h2 {
            color: #fe2c55;
            margin-bottom: 1rem;
        }

        form.card {
            background: #1c1c1e;
            padding: 2rem;
            border-left: 6px solid #25f4ee;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        label {
            display: block;
            margin-top: 1rem;
            margin-bottom: 0.3rem;
            color: #25f4ee;
        }

        input, textarea {
            width: 100%;
            padding: 0.6rem;
            border: none;
            border-radius: 4px;
            background: #292929;
            color: #f5f5f5;
            font-size: 1rem;
        }

        .actions {
            margin-top: 1.5rem;
        }

        .button {
            padding: 0.6rem 1.2rem;
            margin-right: 0.5rem;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            background: #25f4ee;
            color: #000;
        }

        .button:hover {
            background: #20d9d2;
        }

        .ref-links {
            margin-top: 1rem;
        }

        .ref-links .link-group {
            margin-bottom: 1rem;
        }

        .ref-links input {
            margin-top: 0.2rem;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="content-wrapper">
    <h2>✏️ Edit Meme: <?= htmlspecialchars($meme['name']) ?></h2>

    <form class="card" method="POST" action="update_meme.php">
        <input type="hidden" name="id" value="<?= $meme['meme_id'] ?>">

        <label>Name</label>
        <input name="name" value="<?= htmlspecialchars($meme['name']) ?>" required>

        <label>Origin Platform</label>
        <input name="origin_platform" value="<?= htmlspecialchars($meme['origin_platform']) ?>">

        <label>First Appearance</label>
        <input name="first_appearance" type="date" value="<?= htmlspecialchars($meme['first_appearance']) ?>">

        <label>Description</label>
        <textarea name="description" rows="4" required><?= htmlspecialchars($meme['description']) ?></textarea>

        <div class="ref-links">
            <label>Reference Links</label>
            <?php while ($link = $reference_links->fetch_assoc()): ?>
                <div class="link-group">
                    <input name="links[]" value="<?= htmlspecialchars($link['link']) ?>" placeholder="Link">
                    <input name="descriptions[]" value="<?= htmlspecialchars($link['description']) ?>" placeholder="Description (optional)">
                </div>
            <?php endwhile; ?>
        </div>

        <div class="actions">
            <button class="button" type="submit" formaction="update_meme.php">💾 Save Changes</button>
        </div>
    </form>
</div>

</body>
</html>
