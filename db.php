<?php
// db.php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'mini_social_db';

$mysqli = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
?>
