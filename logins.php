<!-- <?php
require_once __DIR__ . '/auth.php';
try_remember_login();

if (is_logged_in()) {
    header('Location: tools.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if ($username === '' || $password === '') {
        $error = 'Fill all fields';
    } else {
        $stmt = $mysqli->prepare("SELECT id, password, username FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $row = $res->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                login_user($row['id'], $row['username']);
                if ($remember) create_remember_token($row['id']);
                header('Location: tools.php');
                exit;
            }
        }
        $error = 'Invalid credentials';
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login - Tools Library</title></head>
<body>
<?php if ($error): ?><p style="color:red"><?=htmlspecialchars($error)?></p><?php endif; ?>
<form method="post">
    <label>Username <input name="username" required></label><br>
    <label>Password <input name="password" type="password" required></label><br>
    <label><input type="checkbox" name="remember"> Remember me</label><br>
    <button type="submit">Login</button>
</form>
</body>
</html> -->
