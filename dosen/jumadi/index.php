<?php
  require_once '../../db.php'; 

  // Get the folder name (e.g., 'jumadi' or 'abcd') to use as a slug
  $slug = basename(dirname(__FILE__));

  try {
      // 1. Fetch this specific professor
      // We assume you'll add a 'slug' column to your table or match by name
      $profStmt = $pdo->prepare("SELECT * FROM professors WHERE name LIKE ? LIMIT 1");
      $profStmt->execute(["%$slug%"]);
      $professor = $profStmt->fetch();

      if (!$professor) {
          // Fallback if DB is empty or name doesn't match folder
          $professor = [
              "name" => "Unknown Professor",
              "bio"  => "Details coming soon.",
              "photo" => "../../assets/images/default.jpg"
          ];
      }

      // 2. Fetch articles (Ideally linked to this professor, but currently global)
      $stmt = $pdo->query("SELECT title, date, content FROM articles ORDER BY date DESC");
      $articles = $stmt->fetchAll();

  } catch (Exception $e) {
      $articles = [];
      $professor = ["name" => "Database Error", "bio" => $e->getMessage(), "photo" => ""];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($professor["name"]) ?> | UNM JTIK</title>
  <link rel="stylesheet" href="../../style.css">
</head>
<body>

<?php include '../../header.php'; ?>

<div class="container">

  <div class="card professor-profile">
    <div class="professor-layout">
      <img
        src="<?= htmlspecialchars($professor["photo"]) ?>"
        alt="<?= htmlspecialchars($professor["name"]) ?>"
        style="width:160px; height:160px; object-fit: cover; border-radius:8px;"
      >

      <div>
        <h1><?= htmlspecialchars($professor["name"]) ?></h1>
        <p><?= nl2br(htmlspecialchars($professor["bio"])) ?></p>
      </div>
    </div>
  </div>

  <div class="card">
    <h2>Published Articles</h2>

    <?php if (!empty($articles)) : ?>
      <ul class="article-list">
        <?php foreach ($articles as $pub) : ?>
          <li style="margin-bottom: 1rem;">
            <strong><?= htmlspecialchars($pub["title"]) ?></strong><br>
            <small>Published on <?= date("F j, Y", strtotime($pub["date"])) ?></small>
            <?php if (!empty($pub['content'])): ?>
              <p style="font-size: 0.9em; color: #555;"><?= htmlspecialchars($pub['content']) ?></p>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else : ?>
      <p>No publications available yet.</p>
    <?php endif; ?>
  </div>

</div>

<?php include '../../footer.php'; ?>

</body>
</html>
