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
    $professor_id = $_POST['professor_id'] ?? '';
    
    // Default to the existing filename in the database
    $fileNameToStore = $article['content']; 

    // Check if a NEW file was uploaded
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../uploads/';
        
        $originalName = basename($_FILES['pdf_file']['name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if ($extension === 'pdf') {
            // Generate new name
            $newFileName = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $originalName);
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $destination)) {
                // SUCCESS: Update the variable to the new filename
                $fileNameToStore = $newFileName;
                
                // OPTIONAL: Delete the old file from the server to save space
                if (!empty($article['content']) && file_exists($uploadDir . $article['content'])) {
                    unlink($uploadDir . $article['content']);
                }
            } else {
                $message = "Error: Could not save the new file.";
            }
        } else {
            $message = "Error: Only PDF files are allowed.";
        }
    }

    if (empty($message) && $title && $date && $professor_id) {
        $stmt = $pdo->prepare("
            UPDATE articles
            SET professor_id = ?, title = ?, date = ?, content = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $professor_id,
            $title,
            $date,
            $fileNameToStore,
            $id
        ]);

        $message = "Article updated successfully.";

        // Refresh data to show changes in form
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch();
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
            <p style="color: green; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label>Title *</label><br>
            <input type="text" name="title" required
                   value="<?= htmlspecialchars($article['title']) ?>"
                   style="width:100%; padding:8px; margin-bottom:15px;">

            <label>Professor *</label><br>
            <select name="professor_id" required
                    style="width:100%; padding:8px; margin-bottom:15px;">
                <?php foreach ($professors as $prof): ?>
                    <option value="<?= $prof['id'] ?>"
                        <?= ($prof['id'] == $article['professor_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prof['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Date *</label><br>
            <input type="date" name="date" required
                   value="<?= htmlspecialchars($article['date']) ?>"
                   style="width:100%; padding:8px; margin-bottom:15px;">

            <label>Current PDF File</label><br>
            <p style="background: #f4f4f4; padding: 8px; font-size: 0.9em; border-radius: 4px;">
                📄 <?= !empty($article['content']) ? htmlspecialchars($article['content']) : "No file uploaded." ?>
            </p>

            <label>Upload New PDF (Leave blank to keep current)</label><br>
            <input type="file" name="pdf_file" accept=".pdf"
                   style="width:100%; padding:8px; margin-bottom:20px; border: 1px solid #ccc;">

            <button type="submit">Update Article</button>

        </form>

        <br>
        <a href="index.php">← Back to Articles</a>

    </div>
</div>

<?php include '../../footer.php'; ?>

</body>
</html>
