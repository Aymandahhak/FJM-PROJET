<?php
// Start the session to access the logged-in user's data
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: loginAdmin.php');
    exit();
}

// Sample user data from session
$user_id = $_SESSION['user_id']; // User's ID
$user_name = $_SESSION['nom']; // User's name
$user_email = $_SESSION['email']; // User's email

// Initialize message variable
$message = '';

// Handle form submission (e.g., changing the password)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    
    if (!empty($new_password)) {
        // Update password logic here (e.g., hash the password and update in the database)
        // Assuming PDO connection is already established
        try {
            // Update the password in the database (ensure you hash the password)
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?");
            $stmt->execute([$hashed_password, $user_id]);

            $message = 'Password updated successfully!';
        } catch (PDOException $e) {
            $message = 'Error updating password: ' . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="User Settings Page">
    <meta name="author" content="Your Name">
    <title>Settings</title>

    <!-- Include your CSS files -->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body>
    <div class="container">
        <h1>User Settings</h1>

        <?php if ($message) : ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form action="settings.php" method="post">
            <div class="form-group">
                <label for="new_password">Change Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password">
            </div>
            <button type="submit" class="btn btn-success">Update Password</button>
        </form>

        <a href="indexAdmin.php" class="btn btn-primary">Back to Dashboard</a>
        <a href="logoutAdmin.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Include your JavaScript files -->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
</body>

</html>
