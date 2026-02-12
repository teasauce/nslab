<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';

$message = "";

/* =========================
   FETCH PROFESSORS (PDO)
========================= */
$stmt = $pdo->query("SELECT id, name FROM professors ORDER BY name ASC");
$professors = $stmt->fetchAll();

/* =========================
   HANDLE FORM SUBMIT
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $date = $_POST['date'] ?? '';
    $content = trim($_POST['content'] ?? '');
    $professor_id = $_POST['professor_id'] ?? '';

    if ($title && $date && $professor_id) {

        $stmt = $pdo->prepare("
            INSERT INTO articles (professor_id, title, date, content)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $professor_id,
            $title,
            $date,
            $content
        ]);

        $message = "Article created successfully.";

    } else {
        $message = "Please fill all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Article</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<?php include '../../header.php'; ?>

<div class="container">
    <div class="card" style="max-width: 700px; margin: auto;">

        <h1>Create New Article</h1>

        <?php if ($message): ?>
            <p style="margin-bottom:15px;">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <form method="POST">

            <label>Title *</label><br>
            <input type="text"
                   name="title"
                   required
                   style="width:100%; padding:8px; margin-bottom:15px;"
                   value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">

            <label>Professor *</label><br>
            <select name="professor_id"
                    required
                    style="width:100%; padding:8px; margin-bottom:15px;">
                <option value="">Select Professor</option>
                <?php foreach ($professors as $prof): ?>
                    <option value="<?= $prof['id'] ?>"
                        <?= (($_POST['professor_id'] ?? '') == $prof['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prof['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Date *</label><br>
            <input type="date"
                   name="date"
                   required
                   style="width:100%; padding:8px; margin-bottom:15px;"
                   value="<?= htmlspecialchars($_POST['date'] ?? '') ?>">

            <label>Content</label><br>
            <textarea name="content"
                      rows="8"
                      style="width:100%; padding:8px; margin-bottom:20px;"><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>

            <button type="submit" style="padding:10px 20px;">
                Publish Article
            </button>

        </form>

    </div>
</div>

<?php include '../../footer.php'; ?>

</body>
</html>
