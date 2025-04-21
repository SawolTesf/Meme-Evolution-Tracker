<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    die("Access denied.");
}

$id = $_GET['id'] ?? null;
if (!$id) die("No meme ID specified.");

$stmt = $conn->prepare("SELECT * FROM MEME WHERE meme_id = ?");
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
    <title>Moderate Meme – Meme Wiki</title>
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
        }

        .approve-btn {
            background: #25f4ee;
            color: #000;
        }

        .delete-btn {
            background: #ff4c4c;
            color: white;
        }

        .delete-btn:hover {
            background: #cc0000;
        }

        .approve-btn:hover {
            background: #20d9d2;
        }

        .ref-links {
            margin-top: 1rem;
        }

        .ref-links .link-group {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="content-wrapper">
    <h2>📜 Review: <?= htmlspecialchars($meme['name']) ?></h2>

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
                    <input type="hidden" name="link_ids[]" value="<?= $link['id'] ?>">
                    <input name="links[]" value="<?= htmlspecialchars($link['link']) ?>" placeholder="Link">
                    <input name="descriptions[]" value="<?= htmlspecialchars($link['description']) ?>" placeholder="Description (optional)">
                </div>
            <?php endwhile; ?>
        </div>

        <div class="actions">
            <button class="button approve-btn" type="submit" formaction="approve_meme.php">✅ Approve</button>
            <button class="button delete-btn" type="submit" formaction="delete.php" onclick="return confirm('Are you sure?')">🗑️ Deny/Delete</button>
            <button class="button" type="submit" formaction="update_meme.php">💾 Save Changes</button>
        </div>
    </form>
</div>

</body>
</html>
