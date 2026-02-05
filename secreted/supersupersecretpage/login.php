<?php
session_start();

// If already logged in, redirect
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: admin/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // TEMP credentials (replace with DB later)
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin/dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | UNM JTIK</title>
  <link rel="stylesheet" href="../../style.css">
</head>
<body>

<div class="container">
  <div class="card" style="max-width:400px;margin:60px auto;">
    <h1>Admin Login</h1>

    <?php if ($error): ?>
      <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
      <label>
        Username
        <input type="text" name="username" required>
      </label>

      <label>
        Password
        <input type="password" name="password" required>
      </label>

      <button type="submit">Login</button>
    </form>
  </div>
</div>

</body>
</html>
