<?php
require_once __DIR__ . '/auth.php';
session_start();
logout_user();
header("Location: login.php");
exit;
?>
