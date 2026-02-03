<?php
// ==========================
// TEMP DATA (replace with DB later)
// ==========================
$professors = [
    [
        "name" => "Dr. Jumadi M. Parenreng, S.Pd., M.Pd.",
        "slug" => "jumadi",
        "photo" => "assets/images/jumadi.jpg",
        "field" => "Education Technology"
    ],
    [
        "name" => "Dr. ABCD, S.Kom., M.Kom.",
        "slug" => "abcd",
        "photo" => "assets/images/default.jpg",
        "field" => "Computer Science"
    ]
];
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
        <a href="dosen/<?= $prof['slug']; ?>/" class="professor-card">

          <img
            src="<?= $prof['photo']; ?>"
            alt="Photo of <?= $prof['name']; ?>"
            onerror="this.src='assets/images/default.jpg';"
          >

          <div class="professor-info">
            <h3><?= $prof['name']; ?></h3>
            <small><?= $prof['field']; ?></small>
          </div>

        </a>
      <?php endforeach; ?>

    </div>
  </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
