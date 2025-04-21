<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$success = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $origin_platform = $_POST['origin_platform'];
    $first_appearance = $_POST['first_appearance'];
    $description = $_POST['description'];

    if (!$name || !$description) {
        $error = "Name and description are required.";
    } elseif (!empty($first_appearance) && strtotime($first_appearance) < strtotime('2000-01-01')) {
        $error = "⛔ Sorry, only memes released after the year 2000 are accepted.";
    } else {
        $stmt = $conn->prepare("INSERT INTO MEME (name, origin_platform, first_appearance, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $origin_platform, $first_appearance, $description);

        if ($stmt->execute()) {
            $success = true;
            $meme_id = $stmt->insert_id;

            if (!empty($_POST['links'])) {
                $link_stmt = $conn->prepare("INSERT INTO MEME_REFERENCE_LINK (meme_id, link, description) VALUES (?, ?, ?)");

                foreach ($_POST['links'] as $index => $link) {
                    $link = trim($link);
                    $desc = trim($_POST['descriptions'][$index] ?? '');

                    if ($link) {
                        $link_stmt->bind_param("iss", $meme_id, $link, $desc);
                        $link_stmt->execute();
                    }
                }
            }

        } else {
            $error = "Something went wrong. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Meme – Meme Wiki</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
            color: #f5f5f5;
            min-height: 100vh;
            padding-top: 5rem;
        }

        .content-wrapper {
            max-width: 800px;
            margin: auto;
            padding: 2rem;
        }

        h2 {
            color: #fe2c55;
            margin-bottom: 1rem;
        }

        .meme-form form {
            background: #1c1c1e;
            padding: 2rem;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        .meme-form label {
            display: block;
            margin-top: 1rem;
            margin-bottom: 0.3rem;
            color: #25f4ee;
        }

        .meme-form input,
        .meme-form textarea {
            width: 100%;
            padding: 0.7rem;
            font-size: 1rem;
            border: none;
            border-radius: 4px;
            background: #292929;
            color: #f5f5f5;
        }

        .meme-form button {
            margin-top: 1.5rem;
            padding: 0.7rem 1.5rem;
            background: #fe2c55;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #e0274a;
        }

        .message {
            margin-top: 1rem;
            padding: 0.8rem;
            border-radius: 5px;
            font-weight: bold;
        }

        .success {
            background-color: #00331f;
            color: #25f4ee;
        }

        .error {
            background-color: #4a0000;
            color: #ff4c4c;
        }

        .link-group {
            margin-top: 0.8rem;
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }
        .link-group input {
            background: #292929;
            color: #f5f5f5;
            border: none;
            padding: 0.5rem;
            border-radius: 4px;
            font-size: 0.95rem;
        }

    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="content-wrapper">
    <h2>Submit a Meme</h2>

    <?php if ($success): ?>
        <div class="message success">✅ Meme submitted successfully!</div>
    <?php elseif ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="meme-form">
    <label>Name*</label>
        <input name="name" required>

        <label>Origin Platform</label>
        <input name="origin_platform">

        <label>First Appearance (YYYY-MM-DD)</label>
        <input name="first_appearance" type="date">

        <label>Description*</label>
        <textarea name="description" rows="4" required></textarea>

        <div id="reference-links">
            <label>Reference Links</label>
            <div class="link-group">
                <input name="links[]" placeholder="https://example.com/meme" />
                <input name="descriptions[]" placeholder="Description (optional)" />
            </div>
        </div>

        <button type="button" onclick="addReferenceLink()" style="margin-top: 1rem; background: #25f4ee; color: #000; font-weight: bold; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer;">
            ➕ Add Another Link
        </button>


        <button type="submit">Submit Meme</button>
    </form>

    <script>
        function addReferenceLink() {
            const group = document.createElement('div');
            group.className = 'link-group';
            group.innerHTML = `
            <input name="links[]" placeholder="https://example.com/meme" />
            <input name="descriptions[]" placeholder="Description (optional)" />
        `;
            document.getElementById('reference-links').appendChild(group);
        }
    </script>

</div>

</body>
</html>
