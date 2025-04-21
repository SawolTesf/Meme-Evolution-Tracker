<?php
session_start();
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meme Wiki – About</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
            color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        .card {
            background: #1c1c1e;
            padding: 1.5rem;
            border-left: 6px solid #25f4ee;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        p {
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .back-link {
            display: inline-block;
            margin-top: 1.5rem;
            color: #25f4ee;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
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
        <h2>About Meme Wiki</h2>
        <div class="card">
            <p><strong>Meme Wiki</strong> is a living archive of internet culture — dedicated to tracking, analyzing, and archiving memes as they rise and fall across platforms.</p>

            <p>Each meme includes detailed info like origin platform, timeline, references, and even real-time Google Trends charts.</p>

            <p>As a registered user, you can explore, and soon — contribute memes to the archive. Stay tuned for more updates!</p>

            <p>Thanks for helping preserve internet folklore 💾🌐</p>

            <a class="back-link" href="index.php">&larr; Back to Home</a>
        </div>
    </div>
</div>

<div class="spacer"></div>

</body>
</html>
