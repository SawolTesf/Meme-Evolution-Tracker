<?php
require 'db.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            header("Location: login.php?user_exists=1");
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hash);

        if ($stmt->execute()) {
            header("Location: login.php?registered=1");
            exit;
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register – Meme Wiki</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0a0a0a, #111);
            color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #1a1a1a;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.2);
            width: 330px;
        }

        h2 {
            text-align: center;
            color: #FF0000;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        input {
            width: 100%;
            padding: 0.7rem;
            margin: 0.5rem 0;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            background: #292929;
            color: #f5f5f5;
        }

        input:focus {
            outline: 2px solid #FF0000;
        }

        button {
            width: 100%;
            background: #FF0000;
            border: none;
            padding: 0.7rem;
            font-size: 1rem;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 1rem;
            transition: background 0.2s ease;
        }

        button:hover {
            background: #cc0000;
        }

        .register-button {
            color: #FF0000;
            text-align: center;
            display: block;
            margin-top: 1.2rem;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .register-button:hover {
            text-decoration: underline;
        }

        .error {
            text-align: center;
            margin-bottom: 0.8rem;
            padding: 0.5rem;
            border-radius: 5px;
            background-color: #4a0000;
            color: #ff4c4c;
            font-size: 0.9rem;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .wiki-title {
            font-size: 2.4rem;
            font-weight: bold;
            color: #ff4c4c;
            text-align: center;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <h1 class="wiki-title">Meme Wiki</h1>

    <div class="login-container">
        <h2>Register</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input name="username" required placeholder="Username">
            <input name="password" type="password" required placeholder="Password">
            <input name="confirm_password" type="password" required placeholder="Confirm Password">
            <button type="submit">Register</button>
        </form>

        <a href="login.php" class="register-button">Already have an account? Log in</a>
    </div>
</div>

</body>
</html>
