<?php
$newlyAdded = 
[
    ["title" => "Innovative AI Techniques in Education", "date" => "2026-01-09"],
    ["title" => "Climate Change Impact on Agriculture", "date" => "2026-01-07"],
    ["title" => "Advances in Quantum Computing", "date" => "2026-01-06"],
    ["title" => "Behavioral Economics and Policy", "date" => "2026-01-05"]
];

$issues = 
[
    "Journal of Computer Science (Vol. 15 No. 1)",
    "Environmental Studies Today (Vol. 8 No. 3)",
    "Modern Physics Letters (Vol. 30 No. 2)"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>UNM JTIK Lab Article Platform</title>

  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'?>

<div class="container">
  <div class="card">
      <h3>Newly Added Articles</h3>
      <?php foreach ($newlyAdded as $article): ?>
          <div class="item">
              <strong><?= $article['title'] ?></strong>
              <div class="date"><?= $article['date'] ?></div>
          </div>
      <?php endforeach; ?>
  </div>

  <div class="card">
      <h3>Newly Released Issues</h3>
      <?php foreach ($issues as $issue): ?>
          <div class="item">
              <strong><?= $issue ?></strong>
          </div>
      <?php endforeach; ?>
  </div>
</div>

<?php include 'footer.php'?>

</body>
</html>
