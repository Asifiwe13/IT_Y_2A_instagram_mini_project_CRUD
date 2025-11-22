<?php
require_once __DIR__ . '/db.php';
session_start();

$error = '';
if (isset($_POST['submit'])) {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $error = "Fill all fields.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Registration failed: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instagram Signup</title>
<link href="https://fonts.googleapis.com/css2?family=Billabong&display=swap" rel="stylesheet">
<style>
body {
    background: #fafafa;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    width: 350px;
    padding: 40px;
    background: white;
    border: 1px solid #dbdbdb;
    text-align: center;
    border-radius: 8px;
}

h1 {
    font-family: 'Billabong', cursive;
    font-size: 48px;
    margin-bottom: 20px;
}

input {
    width: 100%;
    padding: 10px;
    margin-top: 8px;
    border: 1px solid #dbdbdb;
    border-radius: 4px;
    background: #fafafa;
    box-sizing: border-box;
}

button {
    width: 100%;
    margin-top: 12px;
    padding: 10px;
    background: #3897f0;
    color: white;
    border: none;
    font-weight: bold;
    border-radius: 4px;
    cursor: pointer;
}

.error {
    color: red;
    margin-bottom: 10px;
}

.small {
    margin-top: 15px;
    font-size: 14px;
}

.small a {
    color: #3897f0;
    text-decoration: none;
}
</style>
</head>
<body>
<div class="container">
    <h1>Instagram</h1>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="submit">Sign Up</button>
    </form>

    <p class="small">
        Already have an account? <a href="login.php">Log In</a>
    </p>
</div>
</body>
</html>
