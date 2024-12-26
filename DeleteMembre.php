<?php
require('connecter.php');

// Check if member ID is provided for deletion
if (isset($_GET['id'])) {
    $memberId = $_GET['id'];

    // Delete member query
    $query = $pdo->prepare("DELETE FROM members WHERE id = :id");
    $query->bindParam(':id', $memberId, PDO::PARAM_INT);
    $query->execute();

    // Redirect to the admin dashboard after deletion
    header('Location: Admins.php');
    exit();
}