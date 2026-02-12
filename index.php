<?php
require_once 'includes/db.php';

// Fetch professors
$stmt = $pdo->query("SELECT name, slug, photo FROM professors ORDER BY name ASC");
$professors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>UNM JTIK Lab Article Platform</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

  <!-- ABOUT SECTION -->
  <div class="card">
    <h1>About</h1>
    <p>
      The JTIK Lab Article Platform is a centralized academic portal designed 
      to support the dissemination and management of scholarly works produced 
      by lecturers and researchers within the JTIK laboratory environment.
    </p>

    <p>
      Each lecturer is provided with a dedicated profile page where published 
      research and academic information can be accessed in a structured and 
      user-friendly format.
    </p>

    <p>
      The platform is built with scalability and maintainability in mind, 
      allowing future backend expansion such as advanced filtering, 
      authentication systems, and content management features.
    </p>
  </div>

  <!-- PROFESSORS SECTION -->
  <div class="card">
    <h1>List of Professors</h1>

    <?php if (!empty($professors)): ?>
      <div class="professor-list">

        <?php foreach ($professors as $prof): ?>
          <a 
            href="dosen/index.php?slug=<?= htmlspecialchars($prof['slug']) ?>" 
            class="professor-box"
          >
            <img 
              src="<?= htmlspecialchars($prof['photo']) ?>" 
              alt="Photo of <?= htmlspecialchars($prof['name']) ?>"
              onerror="this.src='assets/images/default.jpg';"
            >
            <span><?= htmlspecialchars($prof['name']) ?></span>
          </a>
        <?php endforeach; ?>

      </div>
    <?php else: ?>
      <p>No professors available yet.</p>
    <?php endif; ?>

  </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
