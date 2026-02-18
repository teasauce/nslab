<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("Invalid professor ID.");
}

/* =========================
   FETCH PROFESSOR
========================= */
$stmt = $pdo->prepare("SELECT * FROM professors WHERE id = ?");
$stmt->execute([$id]);
$professor = $stmt->fetch();

if (!$professor) {
    die("Professor not found.");
}

$message = "";

/* =========================
   SLUG GENERATOR
========================= */
function generateSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    return trim($slug, '-');
}

/* =========================
   HANDLE UPDATE
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $photo = trim($_POST['photo'] ?? '');

    if ($name) {

        $slug = generateSlug($name);

        $stmt = $pdo->prepare("
            UPDATE professors
            SET name = ?, slug = ?, bio = ?, photo = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $name,
            $slug,
            $bio,
            $photo,
            $id
        ]);

        $message = "Professor updated successfully.";

        // Refresh professor data
        $stmt = $pdo->prepare("SELECT * FROM professors WHERE id = ?");
        $stmt->execute([$id]);
        $professor = $stmt->fetch();

    } else {
        $message = "Name is required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Professor</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<?php include '../../header.php'; ?>

<div class="container">
    <div class="card" style="max-width:700px; margin:auto;">

        <h1>Edit Professor</h1>

        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">

            <label>Name *</label><br>
            <input type="text"
                   name="name"
                   required
                   value="<?= htmlspecialchars($professor['name']) ?>"
                   style="width:100%; padding:8px; margin-bottom:15px;">

            <label>Photo Path (assets/images/...)</label><br>
            <input type="text"
                   name="photo"
                   value="<?= htmlspecialchars($professor['photo']) ?>"
                   style="width:100%; padding:8px; margin-bottom:15px;">

            <label>Bio</label><br>
            <textarea name="bio"
                      rows="6"
                      style="width:100%; padding:8px; margin-bottom:20px;"><?= htmlspecialchars($professor['bio']) ?></textarea>

            <button type="submit">Update Professor</button>

        </form>

        <br>
        <a href="index.php">← Back to Professors</a>

    </div>
</div>

<?php include '../../footer.php'; ?>

</body>
</html>
