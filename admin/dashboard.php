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

<div class="admin-wrapper">
  <div class="admin-card">
    <h1 class="admin-title">Admin Dashboard</h1>
    <p class="admin-subtitle">Manage your website content</p>

    <div class="admin-grid">
      
      <a href="professors/index.php" class="admin-box">
        <h2>👨‍🏫 Professors</h2>
        <p>Add, edit, or remove professors</p>
      </a>

      <a href="articles/index.php" class="admin-box">
        <h2>📰 Articles</h2>
        <p>Manage articles and publications</p>
      </a>

      <a href="logout.php" class="admin-box danger">
        <h2>🚪 Logout</h2>
        <p>End admin session</p>
      </a>

    </div>
  </div>
</div>

<?php include '../footer.php'; ?>

</body>
</html>