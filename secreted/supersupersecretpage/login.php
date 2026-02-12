<?php
session_start();
require_once 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($admin = $result->fetch_assoc()) {

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];

            header("Location: admin/dashboard.php");
            exit;
        }
    }

    $error = "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<?php include '../../header.php'; ?>

<div class="container">
    <div class="card" style="max-width: 400px; margin: auto;">

        <h2>Admin Login</h2>

        <?php if ($error): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            
            <label>Username</label><br>
            <input type="text" name="username" required style="width: 100%; padding: 8px; margin-bottom: 15px;">
            
            <label>Password</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 8px; margin-bottom: 20px;">

            <button type="submit" style="width: 100%; padding: 10px;">
                Login
            </button>

        </form>

    </div>
</div>

<?php include '../../footer.php'; ?>

</body>
</html>
