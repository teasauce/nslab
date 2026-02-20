<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid professor ID.");
}

$stmt = $pdo->prepare("SELECT * FROM professors WHERE id = ?");
$stmt->execute([$id]);
$professor = $stmt->fetch();

if (!$professor) {
    die("Professor not found.");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $photoPath = $professor['photo'];

    if ($name) {

        // Check if new file uploaded
        if (!empty($_FILES['photo']['name'])) {

            $uploadDir = __DIR__ . '/../../public/uploads/professors/';
            $fileTmp = $_FILES['photo']['tmp_name'];
            $fileName = $_FILES['photo']['name'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExt, $allowed)) {

                $newFileName = uniqid('prof_') . '.' . $fileExt;
                $destination = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmp, $destination)) {

                    // Delete old image
                    if ($professor['photo']) {
                        $oldPath = __DIR__ . '/../../public/' . $professor['photo'];
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }

                    $photoPath = 'uploads/professors/' . $newFileName;
                }
            }
        }

        $stmt = $pdo->prepare("
            UPDATE professors
            SET name = ?, bio = ?, photo = ?
            WHERE id = ?
        ");

        $stmt->execute([$name, $bio, $photoPath, $id]);

        $message = "Professor updated successfully.";

        // Refresh data
        $stmt = $pdo->prepare("SELECT * FROM professors WHERE id = ?");
        $stmt->execute([$id]);
        $professor = $stmt->fetch();
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

        <form method="POST" enctype="multipart/form-data">

            <label>Name *</label><br>
            <input type="text" name="name"
                   value="<?= htmlspecialchars($professor['name']) ?>"
                   required
                   style="width:100%; padding:8px; margin-bottom:15px;">

            <label>Current Photo</label><br>

            <?php if ($professor['photo']): ?>
                <img src="../../public/<?= htmlspecialchars($professor['photo']) ?>"
                     id="previewImage"
                     style="width:150px; margin-bottom:15px; border-radius:8px;">
            <?php else: ?>
                <img id="previewImage"
                     style="display:none; width:150px; margin-bottom:15px;">
            <?php endif; ?>

            <br>

            <label>Change Photo</label><br>
            <input type="file" name="photo" id="photoInput"
                   accept="image/*"
                   style="margin-bottom:15px;"><br>

            <label>Bio</label><br>
            <textarea name="bio" rows="6"
                      style="width:100%; padding:8px; margin-bottom:20px;"><?= htmlspecialchars($professor['bio']) ?></textarea>

            <button type="submit">Update Professor</button>

        </form>
        <br>
        <a href="index.php" class="button">&larr; Back to Professors</a>

    </div>
</div>

<script>
document.getElementById('photoInput').addEventListener('change', function(event) {

    const file = event.target.files[0];
    const preview = document.getElementById('previewImage');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }
});
</script>

<?php include '../../footer.php'; ?>

</body>
</html>