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

        // Handle File Upload
        if (!empty($_FILES['photo']['name'])) {

            $uploadDir = __DIR__ . '/../../public/uploads/professors/';
            $fileTmp = $_FILES['photo']['tmp_name'];
            $fileName = $_FILES['photo']['name'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Allowed file types
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExt, $allowed)) {

                // Generate unique file name
                $newFileName = uniqid('prof_') . '.' . $fileExt;
                $destination = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmp, $destination)) {
                    $photoPath = 'uploads/professors/' . $newFileName;
                }
            }
        }

        $slug = generateSlug($name);

        $stmt = $pdo->prepare("
            INSERT INTO professors (name, slug, bio, photo)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$name, $slug, $bio, $photoPath]);

        $message = "Professor added successfully.";

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

        <!-- IMPORTANT: enctype added -->
        <form method="POST" enctype="multipart/form-data">

            <label>Name *</label><br>
            <input type="text" name="name" required
                   style="width:100%; padding:8px; margin-bottom:15px;">

            <label>Upload Photo</label><br>
            <input type="file" name="photo" id="photoInput" accept="image/*"
                   style="margin-bottom:15px;"><br>

            <img id="previewImage"
                src=""
                style="display:none; width:150px; margin-bottom:15px; border-radius:8px;">

            <label>Bio</label><br>
            <textarea name="bio" rows="6"
                      style="width:100%; padding:8px; margin-bottom:20px;"></textarea>

            <button type="submit">Save Professor</button>

        </form>
        <br>
        <a href="../dashboard.php" class="button">&larr; Back to Dashboard</a>

    </div>
</div>

<?php include '../../footer.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('photoInput');
    const preview = document.getElementById('previewImage');

    input.addEventListener('change', function(event) {

        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    });

});
</script>
</body>
</html>