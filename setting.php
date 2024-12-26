<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

// Include database connection
require 'connecter.php'; // Replace with your database connection file

// Initialize variables
$message = '';
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input fields
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $message = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $message = 'New password and confirm password do not match.';
    } else {
        try {
            // Fetch the current hashed password from the database
            $stmt = $pdo->prepare("SELECT password FROM admins WHERE id = ?");
            $stmt->execute([$user_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($current_password, $row['password'])) {
                // Hash the new password and update it in the database
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?");
                $update_stmt->execute([$hashed_password, $user_id]);

                $message = 'Password updated successfully!';
            } else {
                $message = 'Current password is incorrect.';
            }
        } catch (PDOException $e) {
            $message = 'Error: ' . htmlspecialchars($e->getMessage());
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <style>
    
    body {
        background: linear-gradient(135deg, #74ebd5, #acb6e5);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: 'Roboto', sans-serif;
    }

    .container {
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 100%;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 1.8rem;
        color: #333;
    }

    .alert {
        margin-bottom: 20px;
        padding: 10px;
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        color: #555;
        margin-bottom: 8px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 4px rgba(0, 123, 255, 0.4);
    }

    .btn {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    .btn:active {
        background-color: #004085;
    }

    .form-footer {
        text-align: center;
        margin-top: 20px;
        color: #777;
        font-size: 14px;
    }

    .form-footer a {
        color: #007bff;
        text-decoration: none;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }
</style>

    </style>
</head>

<body>
    <div class="container">
        <h1>Update Password</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form action="setting.php" method="POST">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    </div>
</body>

</html>
