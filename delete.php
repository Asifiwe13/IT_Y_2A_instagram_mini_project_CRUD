<?php
require_once __DIR__ . '/auth.php';
try_remember_login();
if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}
enforce_session_timeout(1800);

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $mysqli->prepare("DELETE FROM tools WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
header("Location: read.php");
exit;
?>
