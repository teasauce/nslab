<?php
require_once 'includes/db.php';

$stmt = $pdo->query("SELECT id, name, slug, photo FROM professors ORDER BY name ASC");
$professors = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Browse Professors | UNM JTIK</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

  <div class="card">
    <h1>Browse Professors</h1>
    <p>Select a professor to view their profile and published articles.</p>
  </div>

  <div class="card">
    <div class="professor-grid">

      <?php foreach ($professors as $prof) : ?>
        <a href="dosen/index.php?slug=<?= htmlspecialchars($prof['slug']); ?>" class="professor-card">

          <img src="public/<?= htmlspecialchars($prof['photo']); ?>"
          alt="Photo of <?= htmlspecialchars($prof['name']); ?>"
          onerror="this.src='assets/images/default.jpg';">

          <div class="professor-info">
            <h3><?= $prof['name']; ?></h3>
          </div>

        </a>
      <?php endforeach; ?>

    </div>
  </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
