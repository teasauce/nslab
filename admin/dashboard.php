<?php
require_once '../includes/auth.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include '../header.php'; ?>

<div class="container">
  <div class="card">
    <h1>Admin Dashboard</h1>

    <ul>
      <li><a href="professors/index.php">Manage Professors</a></li>
      <li><a href="articles/index.php">Manage Articles</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</div>

<?php include '../footer.php'; ?>

</body>
</html>
