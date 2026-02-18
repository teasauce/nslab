<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';

$stmt = $pdo->query("SELECT * FROM professors ORDER BY name ASC");
$professors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Professors</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<?php include '../../header.php'; ?>

<div class="container">
    <div class="card">

        <h1>Manage Professors</h1>

        <p>
            <a href="create.php">+ Add New Professor</a>
        </p>

        <?php if (!empty($professors)): ?>
            <table style="width:100%; border-collapse: collapse;">
                <tr>
                    <th style="border:1px solid #ddd; padding:8px;">Name</th>
                    <th style="border:1px solid #ddd; padding:8px;">Slug</th>
                    <th style="border:1px solid #ddd; padding:8px;">Actions</th>
                </tr>

                <?php foreach ($professors as $prof): ?>
                    <tr>
                        <td style="border:1px solid #ddd; padding:8px;">
                            <?= htmlspecialchars($prof['name']) ?>
                        </td>
                        <td style="border:1px solid #ddd; padding:8px;">
                            <?= htmlspecialchars($prof['slug']) ?>
                        </td>
                        <td style="border:1px solid #ddd; padding:8px;">
                            <a href="edit.php?id=<?= $prof['id'] ?>">Edit</a> |
                            <a href="delete.php?id=<?= $prof['id'] ?>"
                               onclick="return confirm('Delete this professor?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
        <?php else: ?>
            <p>No professors found.</p>
        <?php endif; ?>

    </div>
</div>

<?php include '../../footer.php'; ?>

</body>
</html>
