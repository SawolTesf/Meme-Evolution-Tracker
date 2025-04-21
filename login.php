<?php
session_start();
require 'db.php';

$success = isset($_GET['registered']) && $_GET['registered'] == 1;
$userExists = isset($_GET['user_exists']) && $_GET['user_exists'] == 1;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password_hash, is_admin FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hash, $is_admin);

    if ($stmt->fetch() && password_verify($password, $hash)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = $is_admin;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login – Meme Wiki</title>
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

        .error, .success, .warning {
            text-align: center;
            margin-bottom: 0.8rem;
            padding: 0.5rem;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .error {
            background-color: #4a0000;
            color: #ff4c4c;
        }

        .warning {
            background-color: #332600;
            color: #ffaa00;
        }

        .success {
            background-color: #002b1f;
            color: #25f4ee;
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
        <h2>Login</h2>

        <?php if ($success): ?>
            <div class="success">🎉 Registration successful! You can now log in.</div>
        <?php endif; ?>

        <?php if ($userExists): ?>
            <div class="warning">⚠️ That username is already registered. Please log in.</div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input name="username" required placeholder="Username">
            <input name="password" type="password" required placeholder="Password">
            <button type="submit">Login</button>
        </form>

        <a href="register.php" class="register-button">Don't have an account? Register</a>
    </div>
</div>

</body>

</html>
