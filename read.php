<?php
require_once __DIR__ . '/auth.php';
try_remember_login();
if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}
enforce_session_timeout(1800);

$result = $mysqli->query("SELECT * FROM tools");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Tools</title>
<link rel="stylesheet" href="style.css">
<style>
table {
    border-collapse: collapse;
    width: 80%;
    margin: 20px auto;
    background-color: #f0f8ff;
}
th, td {
    border: 1px solid #333;
    padding: 8px 12px;
    text-align: center;
}
th {
    background-color: #4868f3;
    color: white;
}
a { color: red; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
</head>
<body>
<h1 style="text-align:center;">Tools List</h1>
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Category</th>
    <th>Description</th>
    <th>Condition</th>
    <th>Actions</th>
</tr>
<?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['id']) ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['category']) ?></td>
    <td><?= htmlspecialchars($row['description']) ?></td>
    <td><?= htmlspecialchars($row['condition']) ?></td>
    <td>
        <a href="update.php?id=<?= $row['id'] ?>">Edit</a> | 
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this tool?');">Delete</a>
    </td>
</tr>
    <?php endwhile; ?>
<?php else: ?>
<tr><td colspan="6">No tools found.</td></tr>
<?php endif; ?>
</table>
<a class="btn" href="tools.php">Back to Dashboard</a>
</body>
</html>
