<?php
session_start();
require_once 'connecter.php'; // Fichier de configuration de la base de données

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php"); 
    exit();
}

// Récupération des informations de l'utilisateur (exemple avec PDO)
$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM entraineur WHERE id = :user_id");
$query->bindParam(':user_id', $user_id);
$query->execute();
$user = $query->fetch();

// Gestion de la soumission du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $age = $_POST['age'];
    $nationalite = $_POST['nationalite'];
    $poste = $_POST['poste'];

    // Si une nouvelle photo est téléchargée
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_name = uniqid() . '_' . basename($_FILES['photo']['name']);
        $photo_path = 'uploads/' . $photo_name;
        
        // Créer le dossier uploads s'il n'existe pas
        if (!is_dir('uploads')) {
            mkdir('uploads', 0755, true);
        }
        
        // Déplacer le fichier uploadé
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
            $photo = $photo_path;
        } else {
            $photo = $user['photo'];
        }
    } else {
        // Garder l'ancienne photo si aucune nouvelle n'est téléchargée
        $photo = $user['photo'];
    }

    // Mise à jour des informations dans la base de données
    $stmt = $pdo->prepare("UPDATE entraineur SET nom = :nom, age = :age, nationalite = :nationalite, photo = :photo, poste = :poste WHERE id = :user_id");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':nationalite', $nationalite);
    $stmt->bindParam(':photo', $photo);
    $stmt->bindParam(':poste', $poste);
    $stmt->bindParam(':user_id', $user_id);

    $update_success = $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .profile-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        .profile-header {
            background-color: #007bff;
            color: white;
            margin: -30px -30px 30px;
            padding: 20px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .profile-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #007bff;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .form-control {
            border-radius: 8px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .photo-upload-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }
        .file-input {
            position: absolute;
            bottom: -30px;
            opacity: 0;
            cursor: pointer;
        }
        .file-label {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 profile-container">
                <div class="profile-header">
                    <h2 class="mb-0">Modifier votre Profil</h2>
                    <a href="entraineur.php" class="btn btn-light">
                        <i class="bi bi-person"></i> Voir Profil
                    </a>
                </div>

                <?php if (isset($update_success) && $update_success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Profil mis à jour avec succès !
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (isset($update_success) && !$update_success): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Erreur lors de la mise à jour du profil.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <!-- Photo Upload -->
                    <div class="photo-upload-container text-center mb-4">
                        <img src="<?= htmlspecialchars($user['photo'] ?: 'placeholder.jpg'); ?>" 
                             alt="Photo de profil" 
                             class="profile-photo mb-3">
                        <input type="file" 
                               class="form-control file-input" 
                               id="photo" 
                               name="photo" 
                               accept="image/*">
                        <label for="photo" class="file-label">
                            <i class="bi bi-upload me-2"></i>Changer la photo
                        </label>
                    </div>
                    
                    <!-- Nom -->
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom Complet</label>
                        <input type="text" 
                               class="form-control" 
                               id="nom" 
                               name="nom" 
                               value="<?= htmlspecialchars($user['nom']); ?>" 
                               required>
                    </div>

                    <!-- Age -->
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" 
                               class="form-control" 
                               id="age" 
                               name="age" 
                               value="<?= htmlspecialchars($user['age']); ?>" 
                               required 
                               min="18" 
                               max="100">
                    </div>

                    <!-- Nationalité -->
                    <div class="mb-3">
                        <label for="nationalite" class="form-label">Nationalité</label>
                        <input type="text" 
                               class="form-control" 
                               id="nationalite" 
                               name="nationalite" 
                               value="<?= htmlspecialchars($user['nationalite']); ?>" 
                               required>
                    </div>

                    <!-- Poste -->
                    <div class="mb-3">
                        <label for="poste" class="form-label">Poste</label>
                        <input type="text" 
                               class="form-control" 
                               id="poste" 
                               name="poste" 
                               value="<?= htmlspecialchars($user['poste']); ?>" 
                               required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            Mettre à Jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview uploaded image
        document.getElementById('photo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.querySelector('.profile-photo').src = e.target.result;
            }
            
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>