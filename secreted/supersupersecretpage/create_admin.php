<?php
require_once 'includes/db.php';

$username = "admin";
$password = "admin123";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashedPassword);
$stmt->execute();

echo "Admin created successfully!";
?>
