<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("Invalid article ID.");
}

/* =========================
   FETCH ARTICLE
========================= */
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    die("Article not found.");
}

/* =========================
   FETCH PROFESSORS
========================= */
$stmt = $pdo->query("SELECT id, name FROM professors ORDER BY name ASC");
$professors = $stmt->fetchAll();

$message = "";

/* =========================
   HANDLE UPDATE
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $date = $_POST['date'] ?? '';
    $content = trim($_POST['content'] ?? '');
    $professor_id = $_POST['professor_id'] ?? '';

    if ($title && $date && $professor_id) {

        $stmt = $pdo->prepare("
            UPDATE articles
            SET professor_id = ?, title = ?, date = ?, content = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $professor_id,
            $title,
            $date,
            $content,
            $id
        ]);

        $message = "Article updated successfully.";

        // Refresh data
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch();

    } else {
        $message = "Please fill all required fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Article</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<?php include '../../header.php'; ?>

<div class="container">
    <div class="card" style="max-width:700px; margin:auto;">

        <h1>Edit Article</h1>

        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">

            <label>Title *</label><br>
            <input type="text"
                   name="title"
                   required
                   value="<?= htmlspecialchars($article['title']) ?>"
                   style="width:100%; padding:8px; margin-bottom:15px;">

            <label>Professor *</label><br>
            <select name="professor_id"
                    required
                    style="width:100%; padding:8px; margin-bottom:15px;">
                <?php foreach ($professors as $prof): ?>
                    <option value="<?= $prof['id'] ?>"
                        <?= ($prof['id'] == $article['professor_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prof['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Date *</label><br>
            <input type="date"
                   name="date"
                   required
                   value="<?= htmlspecialchars($article['date']) ?>"
                   style="width:100%; padding:8px; margin-bottom:15px;">

            <label>Content</label><br>
            <textarea name="content"
                      rows="8"
                      style="width:100%; padding:8px; margin-bottom:20px;"><?= htmlspecialchars($article['content']) ?></textarea>

            <button type="submit">Update Article</button>

        </form>

        <br>
        <a href="index.php">← Back to Articles</a>

    </div>
</div>

<?php include '../../footer.php'; ?>

</body>
</html>
