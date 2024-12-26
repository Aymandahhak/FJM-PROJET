<?php
require('connecter.php');


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $nom = $_POST['nom'];
    $age = $_POST['age'];
    $position = $_POST['position'];
    $status = $_POST['status'];
    $physical_condition = $_POST['physical_condition'];
    $performance = $_POST['performance'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $hometown = $_POST['hometown'];
    $dream = $_POST['dream'];
    $achievements = $_POST['achievements'];
    $medical_status = $_POST['medical_status'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password

    // Handle profile image upload
    $image_path = null;
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image_path"]["name"]);
        if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    // Prepare and execute the insert query
    $sql = "INSERT INTO joueurs (nom, age, position, status, physical_condition, performance, height, weight, hometown, dream, achievements, medical_status, email, password, image_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssiiidssssss", $nom, $age, $position, $status, $physical_condition, $performance, $height, $weight, $hometown, $dream, $achievements, $medical_status, $email, $password, $image_path);

    // Execute query and check if it was successful
    if ($stmt->execute()) {
        echo "New player added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
