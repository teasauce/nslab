<?php
$professor = [
    "name" => "Dr. Jumadi M. Parenreng, S.Pd., M.Pd.",
    "photo" => "../../assets/images/jumadi.jpg",
    "bio" => "Dr. Jumadi M. Parenreng is a lecturer and researcher focusing on education,
              instructional technology, and curriculum development. His work emphasizes
              innovative teaching methods and academic research dissemination."
];
?>

<?php
  require_once '../../db.php'; 
  
  try {
      $stmt = $pdo->query("SELECT title, date FROM articles ORDER BY date DESC");
      $articles = $stmt->fetchAll();
  } catch (Exception $e) {
      // If the table doesn't exist yet, we'll use an empty array so the page doesn't crash
      $articles = [];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $professor["name"] ?> | UNM JTIK</title>
  <link rel="stylesheet" href="../../style.css">
</head>
<body>

<?php include '../../header.php'; ?>

<div class="container">

  <!-- Professor Profile -->
  <div class="card professor-profile">
    <div class="professor-layout">
      <img
        src="<?= $professor["photo"] ?>"
        alt="<?= $professor["name"] ?>"
        style="width:160px; height:auto; border-radius:8px;"
      >

      <div>
        <h1><?= $professor["name"] ?></h1>
        <p><?= $professor["bio"] ?></p>
      </div>
    </div>
  </div>

  <!-- Publications -->
  <div class="card">
    <h2>Published Articles</h2>

    <?php if (!empty($articles)) : ?>
      <ul>
        <?php foreach ($articles as $pub) : ?>
          <li>
            <strong><?= $pub["title"] ?></strong><br>
            <small>Published on <?= $pub["date"] ?></small>
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
