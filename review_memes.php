<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    die("Access denied.");
}

$stmt = $conn->prepare("SELECT meme_id, name, description FROM MEME WHERE is_approved = 0 ORDER BY meme_id DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Memes – Meme Wiki</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
            color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            padding: 8rem 1rem 2rem;
            flex: 1;
        }

        .main {
            width: 100%;
            max-width: 850px;
        }

        h2 {
            margin-bottom: 1rem;
            font-size: 1.6rem;
            color: #ffffff;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: #1c1c1e;
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            border-left: 6px solid #25f4ee;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease;
        }

        li:hover {
            transform: scale(1.01);
        }

        li strong {
            font-size: 1.2rem;
            color: #fe2c55;
        }

        .button {
            display: inline-block;
            margin-top: 0.8rem;
            margin-right: 0.5rem;
            padding: 0.5rem 1rem;
            background: #25f4ee;
            color: #0f0f0f;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.95rem;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background: #20d9d2;
        }

        .delete-button {
            background: #ff4c4c;
            color: white;
        }

        .delete-button:hover {
            background: #cc0000;
        }

        .spacer {
            height: 2rem;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="content-wrapper">
    <div class="main">
        <h2>Meme Submissions for Review 🧾</h2>

        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <strong><?= htmlspecialchars($row['name']) ?></strong><br>
                        <?= nl2br(htmlspecialchars($row['description'])) ?><br><br>

                        <form method="GET" action="moderate.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['meme_id'] ?>">
                            <button class="button">🔍 View Details</button>
                        </form>

                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No new meme submissions to review. 🎉</p>
        <?php endif; ?>
    </div>
</div>

<div class="spacer"></div>

</body>
</html>
