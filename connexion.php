<?php
session_start(); // Gestion des sessions

// Connexion à la base de données
$host = 'localhost';
$dbname = 'projetg';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si le formulaire de connexion est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user is a trainer
    $sql = "SELECT * FROM entraineur WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user ) {
        $_SESSION['user'] = $user['nom'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = 'entraineur';
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        header("Location: index.php");
        exit();
    }

    // Check if the user is a player
    $sql = "SELECT * FROM joueurs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user ) {
        $_SESSION['user'] = $user['nom'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = 'joueur';
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        header("Location: index.php");
        exit();
    }

    // Check if the user is an admin
    $sql = "SELECT * FROM admins WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['nom'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = 'admin';
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        header("Location: index.php");
        exit();
    }

    // Incorrect login
    $message = "Identifiants incorrects.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Sports Academy</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2ecc71;
            --secondary: #3498db;
            --accent: #e74c3c;
            --dark: #2c3e50;
            --light: #ecf0f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Segoe UI', sans-serif;
            background: #000;
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .left-side {
            flex: 1;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('assets3/img/f.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .left-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 132, 85, 0.7), rgba(189, 37, 55, 0.7));
            z-index: 1;
        }

        .left-side-content {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
            padding: 2rem;
        }

        .left-side-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .right-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--dark);
            position: relative;
        }

        .login-card {
            width: 400px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .input-group {
            position: relative;
            margin: 30px 0;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 10px;
            color: var(--light);
            font-size: 16px;
            outline: none;
            transition: 0.3s;
        }

        .input-group label {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light);
            pointer-events: none;
            transition: 0.3s;
        }

        .input-group input:focus~label,
        .input-group input:valid~label {
            top: -10px;
            font-size: 12px;
            color: var(--primary);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            overflow: hidden;
            position: relative;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-side">
            <div class="left-side-content">
                <h1>Bienvenue à FJM</h1>
                
            </div>
        </div>
        <div class="right-side">
            <div class="login-card">
                <h2 style="color: var(--light); text-align: center; margin-bottom: 30px; font-size: 28px;">
                    Connexion
                </h2>

                <form method="POST" action="">
                    <div class="input-group">
                        <input type="email" name="email" required>
                        <label>Email Address</label>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>

                    <?php if (isset($message)): ?>
                        <p style="color: var(--accent); text-align: center;"><?php echo htmlspecialchars($message); ?></p>
                    <?php endif; ?>

                    <button type="submit" class="submit-btn">
                        <span>Login</span>
                    </button>

                    <div style="text-align: center; margin-top: 20px;">
                        <a href="index.php" style="color: var(--light); margin-right: 20px; text-decoration: none;">
                            Accueil
                        </a>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>