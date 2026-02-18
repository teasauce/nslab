<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';

$message = "";

function generateSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    return trim($slug, '-');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $photoPath = null;

    if ($name) {

        $slug = generateSlug($name);

        /* =========================
           HANDLE FILE UPLOAD
        ========================= */
        if (!empty($_FILES['photo']['name'])) {

            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (in_array($_FILES['photo']['type'], $allowedTypes)) {

                $uploadDir = __DIR__ . '/../../assets/images/';
                $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                    $photoPath = 'assets/images/' . $fileName;
                } else {
                    $message = "Image upload failed.";
                }

            } else {
                $message = "Invalid image type. Only JPG, PNG, WEBP allowed.";
            }
        }

        /* =========================
           INSERT INTO DATABASE
        ========================= */
        if (!$message) {

            $stmt = $pdo->prepare("
                INSERT INTO professors (name, slug, bio, photo)
                VALUES (?, ?, ?, ?)
            ");

            $stmt->execute([
                $name,
                $slug,
                $bio,
                $photoPath
            ]);

            $message = "Professor added successfully.";
        }

    } else {
        $message = "Name is required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Professor</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<?php include '../../header.php'; ?>

<div class="container">
    <div class="card" style="max-width:700px; margin:auto;">

        <h1>Add Professor</h1>

        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label>Name *</label><br>
            <input type="text" name="name" required
                   style="width:100%; padding:8px; margin-bottom:15px;">

            <label>Upload Photo</label><br>
            <input type="file" name="photo"
                   accept="image/jpeg, image/png, image/webp"
                   style="margin-bottom:15px;">

            <label>Bio</label><br>
            <textarea name="bio" rows="6"
                      style="width:100%; padding:8px; margin-bottom:20px;"></textarea>

            <button type="submit">Save Professor</button>

        </form>
        <br>
        <a href="index.php" class="button">
            &larr; Back to Professors

    </div>
</div>

<?php include '../../footer.php'; ?>

</body>
</html>
