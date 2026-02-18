<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';

/* =========================
   FETCH ARTICLES + PROFESSOR
========================= */

$stmt = $pdo->query("
    SELECT articles.*, professors.name AS professor_name
    FROM articles
    JOIN professors ON articles.professor_id = professors.id
    ORDER BY articles.date DESC
");

$articles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Articles</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<?php include '../../header.php'; ?>

<div class="container">

    <div class="card">
        <h1>Manage Articles</h1>

        <p>
            <a href="create.php" class="button">
                + Create New Article
            </a>
        </p>

        <?php if (!empty($articles)): ?>
            <table style="width:100%; border-collapse: collapse; margin-top:20px;">
                <thead>
                    <tr style="background:#f0f0f0;">
                        <th style="padding:10px; border:1px solid #ddd;">Title</th>
                        <th style="padding:10px; border:1px solid #ddd;">Professor</th>
                        <th style="padding:10px; border:1px solid #ddd;">Date</th>
                        <th style="padding:10px; border:1px solid #ddd;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $row): ?>
                        <tr>
                            <td style="padding:10px; border:1px solid #ddd;">
                                <?= htmlspecialchars($row['title']) ?>
                            </td>
                            <td style="padding:10px; border:1px solid #ddd;">
                                <?= htmlspecialchars($row['professor_name']) ?>
                            </td>
                            <td style="padding:10px; border:1px solid #ddd;">
                                <?= htmlspecialchars($row['date']) ?>
                            </td>
                            <td style="padding:10px; border:1px solid #ddd;">
                                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                                <a href="delete.php?id=<?= $row['id'] ?>"
                                   onclick="return confirm('Are you sure you want to delete this article?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p>No articles found.</p>
        <?php endif; ?>

    </div>
    <br>
    <a href="../dashboard.php" class="button">
        &larr; Back to Dashboard

</div>

<?php include '../../footer.php'; ?>

</body>
</html>
