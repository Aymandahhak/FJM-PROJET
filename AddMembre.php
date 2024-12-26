<?php
require('connecter.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $metier = $_POST['metier'] ?? '';
    $image = $_FILES['image'] ?? null;

    // Validate inputs
    if (empty($name) || empty($email) || empty($metier) || !$image || $image['error'] !== UPLOAD_ERR_OK) {
        die("All fields are required, including a valid image!");
    }

    // Create a dynamic folder structure
    $uploadBaseDir = 'uploads/'; // Base directory for uploads
    $subFolder = date('Y/m/d'); // Organize by year/month/day
    $targetDir = $uploadBaseDir . $subFolder . '/';

    // Ensure the folder exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create directories recursively
    }

    // Generate a unique name for the uploaded file
    $uniqueName = uniqid() . '-' . basename($image['name']);
    $imagePath = $targetDir . $uniqueName;

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
        die("Failed to upload the image.");
    }

    // Insert data into the database
    $sql = "INSERT INTO members (nom, email, metier, image) VALUES (:name, :email, :metier, :image)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':metier' => $metier,
            ':image' => $imagePath,
        ]);
        header('Location: indexAdmin.php');
        exit;
    } catch (PDOException $e) {
        echo "Error inserting data: " . $e->getMessage();
    }
}
?>
