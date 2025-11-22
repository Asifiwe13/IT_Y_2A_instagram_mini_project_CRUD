<?php
require_once __DIR__ . '/auth.php';
try_remember_login();
if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}
enforce_session_timeout(1800);

$edit_id = (int)($_GET['id'] ?? 0);
$name = $category = $description = $condition = '';

if ($edit_id) {
    $stmt = $mysqli->prepare("SELECT * FROM tools WHERE id=?");
    $stmt->bind_param('i', $edit_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $name = $row['name'];
        $category = $row['category'];
        $description = $row['description'];
        $condition = $row['condition'];
    } else {
        header("Location: read.php");
        exit;
    }
}

if (isset($_POST['update_tool'])) {
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $condition = $_POST['condition'];

    $stmt = $mysqli->prepare("UPDATE tools SET name=?, category=?, description=?, `condition`=? WHERE id=?");
    $stmt->bind_param('ssssi', $name, $category, $description, $condition, $edit_id);
    $stmt->execute();
    header("Location: read.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Tool</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Update Tool</h2>
<form method="POST">
    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>
    <input type="text" name="category" value="<?= htmlspecialchars($category) ?>" required>
    <input type="text" name="description" value="<?= htmlspecialchars($description) ?>" required>
    <select name="condition">
        <option value="new" <?= $condition=='new'?'selected':'' ?>>New</option>
        <option value="good" <?= $condition=='good'?'selected':'' ?>>Good</option>
        <option value="fair" <?= $condition=='fair'?'selected':'' ?>>Fair</option>
        <option value="poor" <?= $condition=='poor'?'selected':'' ?>>Poor</option>
    </select>
    <button type="submit" name="update_tool">Update Tool</button>
</form>
<a class="btn" href="tools.php">Back to Dashboard</a>
</div>
</body>
</html>
