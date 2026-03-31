<?php
require_once 'includes/db.php';
// please change the username and password before running this script, and run it only once to avoid duplicate entries in the database
$username = "admin";
$password = "admin123";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashedPassword);
$stmt->execute();

echo "Admin created successfully!";
?>
