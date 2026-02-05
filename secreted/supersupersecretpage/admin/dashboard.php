<?php
require_once '../includes/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../../../style.css">
</head>
<body>

<?php include '../../../header.php'; ?>

<div class="container">
  <div class="card">
    <h1>Admin Dashboard</h1>
    <p>Welcome. You are logged in as admin.</p>

    <ul>
      <li><a href="#">Upload Article (later)</a></li>
      <li><a href="#">Manage Professors (later)</a></li>
      <li><a href="../logout.php">Logout</a></li>
    </ul>
  </div>
</div>

</body>
</html>
