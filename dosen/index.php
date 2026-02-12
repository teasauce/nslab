<?php
require_once '../includes/db.php';

// Get slug from URL
$slug = $_GET['slug'] ?? null;

if (!$slug) {
    die("No professor specified.");
}

// Fetch professor
$stmt = $pdo->prepare("SELECT * FROM professors WHERE slug = ?");
$stmt->execute([$slug]);
$professor = $stmt->fetch();

if (!$professor) {
    die("Professor not found.");
}

// Fetch articles
$stmt = $pdo->prepare("
    SELECT id, title, date 
    FROM articles 
    WHERE professor_id = ? 
    ORDER BY date DESC
");
$stmt->execute([$professor['id']]);
$articles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($professor['name']) ?> | UNM JTIK</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include '../header.php'; ?>

<div class="container">

    <div class="card profile-card">
        <img 
            src="../<?= htmlspecialchars($professor['photo']) ?>" 
            alt="<?= htmlspecialchars($professor['name']) ?>"
            class="profile-photo"
            onerror="this.src='../assets/images/default.jpg';"
        >

        <div class="profile-info">
            <h1><?= htmlspecialchars($professor['name']) ?></h1>

            <?php if (!empty($professor['bio'])): ?>
                <p><?= nl2br(htmlspecialchars($professor['bio'])) ?></p>
            <?php else: ?>
                <p>No biography available.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card articles-section">
        <h2>Published Articles</h2>

        <?php if (!empty($articles)): ?>
            <div class="article-grid">
                <?php foreach ($articles as $article): ?>
                    <div class="article-card">
                        <h3>
                            <a href="../article.php?id=<?= $article['id'] ?>">
                                <?= htmlspecialchars($article['title']) ?>
                            </a>
                        </h3>
                        <small>
                            <?= htmlspecialchars(date("F j, Y", strtotime($article['date']))) ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No articles yet.</p>
        <?php endif; ?>

        <br>
        <a href="../browse.php">← Back to Professors</a>

    </div>

</div>

<?php include '../footer.php'; ?>

</body>
</html>
