<?php
// Start the session to access the logged-in user's data
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

// Sample user data from session
$user_name = $_SESSION['nom']; // User's name
$user_email = $_SESSION['email']; // User's email
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="User Account Page">
    <meta name="author" content="Your Name">
    <title>Account</title>

    <!-- Include your CSS files -->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <link href="css/theme.css" rel="stylesheet" media="all">
   
    <style>
     body {
    background: linear-gradient(135deg, #74ebd5, #9face6);
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background: #ffffff;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    width: 100%;
    text-align: center;
    animation: fadeIn 0.8s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

h1 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 20px;
    font-weight: 700;
}

p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 15px;
}

p strong {
    color: #222;
    font-weight: 600;
}

.btn {
    font-size: 1rem;
    padding: 12px 25px;
    border-radius: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    text-decoration: none;
    color: #ffffff;
    margin: 10px 5px 0 0;
    display: inline-block;
    transition: all 0.3s ease;
    border: none;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0056b3, #003d80);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c82333, #bd2130);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.btn:focus {
    outline: none;
    box-shadow: 0 0 10px rgba(116, 235, 213, 0.6);
}

@media (max-width: 576px) {
    .container {
        padding: 30px 20px;
    }

    h1 {
        font-size: 1.5rem;
    }

    p {
        font-size: 0.9rem;
    }

    .btn {
        font-size: 0.9rem;
        padding: 10px 20px;
    }
}

    </style>
</head>

<body>
    <div class="container">
        <h1>Account Details</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></p>

        <a href="indexAdmin.php" class="btn btn-primary">Back to Dashboard</a>
        <a href="logoutAdmin.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Include your JavaScript files -->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
</body>

</html>
