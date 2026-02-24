<?php
require_once 'includes/db.php';

$query = trim($_GET['q'] ?? '');

$professors = [];
$articles = [];

if ($query !== '') {

    // Search professors
    $stmt = $pdo->prepare("
        SELECT id, name, slug, photo 
        FROM professors 
        WHERE name LIKE :search
        ORDER BY name ASC
    ");
    $stmt->execute(['search' => "%$query%"]);
    $professors = $stmt->fetchAll();

    // Search articles
    $stmt = $pdo->prepare("
        SELECT id, title 
        FROM articles 
        WHERE title LIKE :search
        ORDER BY date DESC
    ");

    $stmt->execute(['search' => "%$query%"]);
    $articles = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Search Results</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

  <div class="card">
    <h1>Search Results for "<?= htmlspecialchars($query); ?>"</h1>
  </div>

  <!-- Professors -->
  <div class="card">
    <h2>Professors</h2>

    <?php if (count($professors) > 0): ?>
      <div class="professor-grid">
        <?php foreach ($professors as $prof): ?>
          <a href="dosen/index.php?slug=<?= htmlspecialchars($prof['slug']); ?>" class="professor-card">
            <img src="public/<?= htmlspecialchars($prof['photo']); ?>"
                 onerror="this.src='assets/images/default.jpg';">
            <div class="professor-info">
              <h3><?= htmlspecialchars($prof['name']); ?></h3>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>No professors found.</p>
    <?php endif; ?>

  </div>

  <!-- Articles -->
  <div class="card">
    <h2>Articles</h2>

    <?php if (count($articles) > 0): ?>
      <ul>
        <?php foreach ($articles as $article): ?>
          <li>
            <a href="article/index.php?id=<?= htmlspecialchars($article['id']); ?>">
              <?= htmlspecialchars($article['title']); ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No articles found.</p>
    <?php endif; ?>

  </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>