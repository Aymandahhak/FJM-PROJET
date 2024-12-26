<?php
require('connecter.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $image = $_FILES['image'] ?? null;

    // Validate inputs
    if (empty($nom) || empty($email) || empty($password)) {
        die("All fields are required!");
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Handle image upload
    $imagePath = null;
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $uploadBaseDir = 'uploads/admins/'; // Base directory for admin uploads
        if (!is_dir($uploadBaseDir)) {
            mkdir($uploadBaseDir, 0777, true); // Create directory if it doesn't exist
        }

        $uniqueName = uniqid() . '-' . basename($image['name']);
        $imagePath = $uploadBaseDir . $uniqueName;

        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            die("Failed to upload the image.");
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO admins (nom, email, password, image) VALUES (:nom, :email, :password, :image)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':nom' => $nom,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':image' => $imagePath,
        ]);
        header('Location: indexAdmin.php'); // Redirect after successful insertion
        exit;
    } catch (PDOException $e) {
        echo "Error inserting data: " . $e->getMessage();
    }
}
?>
