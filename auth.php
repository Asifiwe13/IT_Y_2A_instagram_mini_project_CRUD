<?php
require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function is_logged_in() {
    return !empty($_SESSION['user_id']);
}

// Log in user
function login_user($user_id, $username, $regenerate = true) {
    if ($regenerate) session_regenerate_id(true);
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['last_active'] = time();
}

// Logout user
function logout_user() {
    $_SESSION = [];
    session_unset();
    session_destroy();
    setcookie('remember_me', '', time() - 3600, '/'); // clear cookie
}

// Session timeout enforcement
function enforce_session_timeout($timeout_seconds = 1800) {
    if (!empty($_SESSION['last_active']) && (time() - $_SESSION['last_active']) > $timeout_seconds) {
        logout_user();
        header("Location: login.php?timeout=1");
        exit;
    }
    $_SESSION['last_active'] = time();
}

// Remember me functionality
function try_remember_login() {
    global $mysqli;
    if (is_logged_in()) return;

    if (!empty($_COOKIE['remember_me'])) {
        $token = $_COOKIE['remember_me'];
        $stmt = $mysqli->prepare("SELECT id, username FROM users WHERE remember_token=?");
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 1) {
            $row = $res->fetch_assoc();
            login_user($row['id'], $row['username']);
        }
    }
}

// Create remember me token
function create_remember_token($user_id) {
    global $mysqli;
    $token = bin2hex(random_bytes(16));
    setcookie('remember_me', $token, time() + 86400*30, '/');
    $stmt = $mysqli->prepare("UPDATE users SET remember_token=? WHERE id=?");
    $stmt->bind_param('si', $token, $user_id);
    $stmt->execute();
}
?>
