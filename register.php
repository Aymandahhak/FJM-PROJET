<?php
require('connecter.php');
session_start();
$error = ''; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_acc'])) {
    $inputFirstName = $_POST['inputFirstName'];
    $inputEmail = $_POST['inputEmail'];
    $inputPassword = $_POST['inputPassword'];
    $inputPasswordConfirm = $_POST['inputPasswordConfirm'];

    // Validate passwords
    if ($inputPassword === $inputPasswordConfirm) {
        try {
            // Check if the email already exists
            $stmt = $pdo->prepare("SELECT email FROM admins WHERE email = ?");
            $stmt->execute([$inputEmail]);
            if ($stmt->rowCount() > 0) {
                $error = 'Email is already registered.';
            } else {
                // Hash the password
                $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

                // Insert new admin into the database
                $stmt = $pdo->prepare("INSERT INTO admins (nom, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$inputFirstName, $inputEmail, $hashedPassword]);

                // Redirect to login.php with success message
                $_SESSION['success'] = 'Account created successfully. Please log in.';
                header('Location: login.php');
                exit();
            }
        } catch (PDOException $e) {
            $error = 'Error: ' . htmlspecialchars($e->getMessage());
        }
    } else {
        $error = 'Passwords do not match.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Register - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3>Create Account</h3></div>
                            <div class="card-body">
                                <!-- Display error message -->
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                                <?php endif; ?>
                                <form method="post">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="inputFirstName" type="text" placeholder="First name" required />
                                        <label>First name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="inputEmail" type="email" placeholder="Email" required />
                                        <label>Email address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="inputPassword" type="password" placeholder="Password" required />
                                        <label>Password</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="inputPasswordConfirm" type="password" placeholder="Confirm Password" required />
                                        <label>Confirm Password</label>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit" name="create_acc">Create Account</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center">
                                <a href="login.php">Already have an account? Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
