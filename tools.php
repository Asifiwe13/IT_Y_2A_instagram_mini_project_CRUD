<?php
require_once __DIR__ . '/auth.php';
try_remember_login();
if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}
enforce_session_timeout(1800);

$error = '';
if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $condition = $_POST['condition'];

    if ($name === '' || $category === '' || $description === '') {
        $error = "All fields are required.";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO tools(name, category, description, `condition`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $name, $category, $description, $condition);
        $stmt->execute();
        $success = "Tool added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tools Library</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h1>Tools Library</h1>
<a class="btn" href="logout.php">Logout</a>
<?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
<?php if (!empty($success)) echo "<div style='color:green;'>$success</div>"; ?>

<form method="POST">
    <input type="text" name="name" placeholder="Tool Name" required>
    <input type="text" name="category" placeholder="Category" required>
    <input type="text" name="description" placeholder="Description" required>
    <select name="condition">
        <option value="new">New</option>
        <option value="good">Good</option>
        <option value="fair">Fair</option>
        <option value="poor">Poor</option>
    </select>
    <button type="submit" name="add">Add Tool</button>
</form>
<a class="btn" href="read.php">View Tools</a>
</div>
</body>
</html>
