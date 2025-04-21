<?php
session_start();
require 'db.php';

$query = trim($_GET['q'] ?? '');

if (!$query) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT meme_id, name, description FROM MEME WHERE name LIKE ? OR description LIKE ?");
$search = "%$query%";
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search – Meme Wiki</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
            color: #f5f5f5;
            min-height: 100vh;
            margin: 0;
            padding-top: 5rem;
        }

        .content-wrapper {
            max-width: 850px;
            margin: auto;
            padding: 2rem;
        }

        h2 {
            margin-bottom: 1rem;
            color: #fe2c55;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: #1c1c1e;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 6px solid #25f4ee;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .result-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #25f4ee;
        }

        .button {
            display: inline-block;
            margin-top: 0.8rem;
            padding: 0.5rem 1rem;
            background: #fe2c55;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }

        .button:hover {
            background: #e0264d;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="content-wrapper">
    <h2>Search Results for "<?= htmlspecialchars($query) ?>"</h2>

    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <div class="result-name"><?= htmlspecialchars($row['name']) ?></div>
                    <div><?= nl2br(htmlspecialchars($row['description'])) ?></div>
                    <a href="meme.php?id=<?= $row['meme_id'] ?>" class="button">View Meme</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No memes found matching your search.</p>
    <?php endif; ?>
</div>

</body>
</html>
