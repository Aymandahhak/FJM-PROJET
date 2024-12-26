<?php
require_once "connecter.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}


$coachId = $_SESSION['user_id'];

function getCoachInfo($pdo, $coachId) {
    $stmt = $pdo->prepare("SELECT * FROM entraineur WHERE id = ?");
    $stmt->execute([$coachId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);

   
}


// Fetch existing diplomes, specialisations, and carrieres
function getDiplomes($pdo, $coachId) {
    $stmt = $pdo->prepare("SELECT * FROM diplomes WHERE entraineur_id = ?");
    $stmt->execute([$coachId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSpecialisations($pdo, $coachId) {
    $stmt = $pdo->prepare("SELECT * FROM specialisations WHERE entraineur_id = ?");
    $stmt->execute([$coachId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCarrieres($pdo, $coachId) {
    $stmt = $pdo->prepare("SELECT * FROM carrieres WHERE id_entraineur = ?");
    $stmt->execute([$coachId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupération des données du coach
$coachInfo = getCoachInfo($pdo, $coachId);


$diplomes = getDiplomes($pdo, $coachId);
$specialisations = getSpecialisations($pdo, $coachId);
$carrieres = getCarrieres($pdo, $coachId);

function getNombreJoueursParTrancheAge($pdo, $coachId) {
    $sql = " SELECT 
            CASE 
                WHEN age BETWEEN 7 AND 10 THEN '7-10 ans'
                WHEN age BETWEEN 11 AND 14 THEN '11-14 ans'
                WHEN age BETWEEN 15 AND 18 THEN '15-18 ans'
                ELSE 'Autres'
            END AS tranche_age,
            COUNT(*) AS nombre_joueurs
        FROM joueurs
        WHERE id_entraineur = :id_entraineur
        GROUP BY tranche_age;
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_entraineur', $coachId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return [];
    }
}

$joueurs_par_age = getNombreJoueursParTrancheAge($pdo, $coachId);




?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Coach</title>
    <link href="css/bootstrap1.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/css/dropmenu.css">

    <style>
        body {
            background-color: #051922 ;
        }
		header {
    background-color: #000; /* Noir */
    color: #fff; /* Texte blanc pour la lisibilité */
    padding: 10px; /* Ajoute un peu d'espacement (facultatif) */
}

.main-menu ul li.active a {
    color: #2596c5;
    font-weight: bold;
}
.timeline-item {
    position: relative;
    padding-left: 20px;
    border-left: 2px solid #e9ecef;
}
.timeline-item::before {
    content: '';
    position: absolute;
    width: 12px;
    height: 12px;
    background-color: #6c757d;
    left: -7px;
    top: 10px;
    border-radius: 50%;
}
.card:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
}

	</style>
	</style>
</head>
<body>
   
    <!-- header -->
    <div class="top-header-area" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- logo -->
                         <!-- logo -->
             <div class="site-logo">
                            <a href="index.php">
                                <img src="assets/img/logo.png" alt="">
                            </a>
                        </div>
                        <!-- logo -->
                        <!-- menu start -->
                        <nav class="main-menu">
                            <ul>
                                <li class="current-list-item"><a href="index.php">Home</a></li>
                                <li><a href="#About">About</a></li>
                                <li><a href="contact.php">Contact</a></li>

                                <?php if (isset($_SESSION['user']) && $_SESSION['user']): ?>
                                    <?php if ($_SESSION['role'] === 'joueur'): ?>
                                        <li><a href="profile_joueur.php">Profile</a></li>
                                    <?php elseif ($_SESSION['role'] === 'entraineur'): ?>
                                        <li><a href="entraineur.php">Profile</a></li>
                                    <?php elseif ($_SESSION['role'] === 'admin'): ?>
                                        <li><a href="indexAdmin.php">Dashboard</a></li>
                                    <?php endif; ?>
                                    <li>
                                        <div class="header-icons">
                                            <div class="user-info">
                                                
                                                <a href="index.php?logout=true" class="logout-btn">Logout</a>
                                            </div>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <li><a href="connexion.php" class="boxed-btn">Connexion</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <!-- <div class="mobile-menu"></div> -->
<div class="mobile-menu"></div>
<!-- menu end -->

                    </div>
                </div>
            </div>
        </div>
    </div>
   <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>GET YOUR FUTURE COACH </p>
                        <h1>Hello Coach <?= e($coachInfo['nom']); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->
    <br>
    <br>
    <div class="container-fluid px-4 py-5">
        <div class="row g-4">
            <!-- Profile Sidebar -->
<?php
// Ensure proper escaping function
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
<style>
body {
    background-color: #f5f7fa;
    font-family: 'Inter', sans-serif;
}

.card {
    border-radius: 20px;
}

h1, h2, h3 {
    color: #333;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-outline-secondary {
    border-color: #ddd;
    color: #333;
}

.btn-lg {
    padding: 0.8rem 1.5rem;
    font-size: 1rem;
}

.shadow {
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
}

.bg-light {
    background-color: #f8f9fa;
    border-radius: 10px;
}

img {
    transition: transform 0.3s ease;
}

img:hover {
    transform: scale(1.05);
}

.btn:hover {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}
</style>
<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Utilisation de 10 colonnes -->
        <div class="col-lg-10 col-md-10">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="card-body p-5 text-center">
                    <!-- Image et nom -->
                    <div class="position-relative d-inline-block mb-4">
                        <img src="<?= e($coachInfo['photo']); ?>" 
                             alt="<?= e($coachInfo['nom']); ?>" 
                             class="img-fluid rounded-circle shadow" 
                             style="width: 150px; height: 150px; object-fit: cover; border: 5px solid #ffffff;">
                        <span class="position-absolute bottom-0 end-0 badge bg-primary rounded-circle" 
                              style="padding: 1rem; transform: translate(25%, 25%);">
                            <i class="fas fa-check text-white"></i>
                        </span>
                    </div>
                    
                    <h1 class="h2 fw-bold text-dark text-uppercase mb-3"><?= e($coachInfo['nom']); ?></h1>
                    <p class="text-muted mb-3">
                        <i class="fas fa-birthday-cake me-2 text-secondary"></i><?= e($coachInfo['age']); ?> ans |
                        <i class="fas fa-flag me-2 text-secondary"></i><?= e($coachInfo['nationalite']); ?>
                    </p>
                    <p class="text-secondary mb-4">
                        <i class="fas fa-user-tie me-2"></i><?= e($coachInfo['poste']); ?>
                    </p>

                    <!-- Actions -->
                    <div class="d-flex justify-content-center gap-3 mb-5">
                        <a href="suiviejoueurs.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-users me-2"></i> Suivi des Joueurs
                        </a>
                        <a href="modifierprofile.php" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-edit me-2"></i> Modifier Profil
                        </a>
                    </div>

                    <!-- Statistiques -->
                    <div class="row text-center bg-light py-4 rounded shadow-sm">
                        <div class="col-4">
                            <h2 class="text-primary fw-bold"><?= !empty($joueurs_par_age) ? $joueurs_par_age[0]['nombre_joueurs'] : '0'; ?></h2>
                            <p class="text-muted">Joueurs</p>
                        </div>
                        <div class="col-4">
                            <h2 class="text-success fw-bold"><?= count($diplomes); ?></h2>
                            <p class="text-muted">Diplômes</p>
                        </div>
                        <div class="col-4">
                            <h2 class="text-warning fw-bold"><?= count($carrieres); ?></h2>
                            <p class="text-muted">Clubs</p>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="mt-5">
                        <h3 class="fw-bold text-dark mb-3">Contact</h3>
                        <a href="mailto:<?= e($coachInfo['email']); ?>" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-envelope me-2"></i><?= e($coachInfo['email']); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Main Content (Utilisation de 10 colonnes) -->
        <div class="col-10">
            
            <!-- Diplômes Section -->
            <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i> Diplômes
                    </h4>
                    <div class="btn-group" role="group">
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#diplomeModal">
                            <i class="fas fa-plus me-1"></i> Ajouter
                        </button>
                        <button class="btn btn-light btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#modifierDiplomeModal">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($diplomes)): ?>
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <?php foreach ($diplomes as $dip): ?>
                                <div class="col">
                                    <div class="bg-light rounded p-3 h-100 shadow-sm">
                                        <h6 class="mb-1"><?= htmlspecialchars($dip['titre']); ?></h6>
                                        <p class="text-muted mb-0">Année : <?= htmlspecialchars($dip['annee']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-light text-center" role="alert">
                            Aucun diplôme trouvé
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Spécialisations Section -->
            <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-star me-2"></i> Spécialisations
                    </h4>
                    <div class="btn-group" role="group">
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#specialisationModal">
                            <i class="fas fa-plus me-1"></i> Ajouter
                        </button>
                        <button class="btn btn-light btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#modifierSpecialisationModal">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($specialisations)): ?>
                        <?php foreach ($specialisations as $spec): ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0"><?= htmlspecialchars($spec['nom']); ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($spec['progression']); ?>%</small>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?= htmlspecialchars($spec['progression']); ?>%" 
                                         aria-valuenow="<?= htmlspecialchars($spec['progression']); ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-light text-center" role="alert">
                            Aucune spécialisation trouvée
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Carrière Section -->
            <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp">
                <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-trophy me-2"></i> Carrière
                    </h4>
                    <div class="btn-group" role="group">
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#carriereModal">
                            <i class="fas fa-plus me-1"></i> Ajouter
                        </button>
                        <button class="btn btn-light btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#modifierCarriereModal">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($carrieres)): ?>
                        <div class="list-group">
                            <?php foreach ($carrieres as $car): ?>
                                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-start bg-light rounded mb-2 shadow-sm">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold"><?= htmlspecialchars($car['club']); ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($car['description']); ?></small>
                                    </div>
                                   
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-light text-center" role="alert">
                            Aucune expérience trouvée
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

    <!-- Modal pour Diplôme -->
    <div class="modal fade" id="diplomeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Diplôme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action ="ajouterinformation.php">
                        <div class="mb-3">
                            <label for="diplome_titre" class="form-label">Titre du diplôme</label>
                            <input type="text" class="form-control" id="diplome_titre" name="diplome_titre" required>
                        </div>
                        <div class="mb-3">
                            <label for="diplome_annee" class="form-label">Année d'obtention</label>
                            <input type="number" class="form-control" id="diplome_annee" name="diplome_annee" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal pour Spécialisation -->
    <div class="modal fade" id="specialisationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une spécialisation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action ="ajouterinformation.php">
                        <div class="mb-3">
                            <label for="specialisation_nom" class="form-label">Nom de la spécialisation</label>
                            <input type="text" class="form-control" id="specialisation_nom" name="specialisation_nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="specialisation_niveau" class="form-label">Niveau (%)</label>
                            <input type="range" class="form-range" id="specialisation_niveau" name="specialisation_niveau" min="0" max="100" step="5" oninput="this.nextElementSibling.value = this.value + '%'">
                            <output>50%</output>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal pour Carrière -->
    <div class="modal fade" id="carriereModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une expérience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action ="ajouterinformation.php">
                        <div class="mb-3">
                            <label for="carriere_club" class="form-label">Club</label>
                            <input type="text" class="form-control" id="carriere_club" name="carriere_club" required>
                        </div>
                        <div class="mb-3">
                            <label for="carriere_description" class="form-label">Description</label>
                            <textarea class="form-control" id="carriere_description" name="carriere_description" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modifierDiplomeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier un Diplôme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="modifierinformation.php">
                    <div class="mb-3">
                        <label for="modifier_diplome_selection" class="form-label">Sélectionner le diplôme à modifier</label>
                        <select class="form-select" id="modifier_diplome_selection" name="modifier_diplome_selection" required>
                            <?php foreach ($diplomes as $dip): ?>
                                <option value="<?= htmlspecialchars($dip['id']); ?>">
                                    <?= htmlspecialchars($dip['titre']); ?> (<?= htmlspecialchars($dip['annee']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modifier_diplome_titre" class="form-label">Nouveau titre du diplôme</label>
                        <input type="text" class="form-control" id="modifier_diplome_titre" name="modifier_diplome_titre">
                    </div>
                    <div class="mb-3">
                        <label for="modifier_diplome_annee" class="form-label">Nouvelle année d'obtention</label>
                        <input type="number" class="form-control" id="modifier_diplome_annee" name="modifier_diplome_annee">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modifierSpecialisationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier une Spécialisation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="modifierinformation.php">
                    <div class="mb-3">
                        <label for="modifier_specialisation_selection" class="form-label">Sélectionner la spécialisation à modifier</label>
                        <select class="form-select" id="modifier_specialisation_selection" name="modifier_specialisation_selection" required>
                            <?php foreach ($specialisations as $spec): ?>
                                <option value="<?= htmlspecialchars($spec['id']); ?>">
                                    <?= htmlspecialchars($spec['nom']); ?> (<?= htmlspecialchars($spec['progression']); ?>%)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modifier_specialisation_nom" class="form-label">Nouveau nom de la spécialisation</label>
                        <input type="text" class="form-control" id="modifier_specialisation_nom" name="modifier_specialisation_nom">
                    </div>
                    <div class="mb-3">
                        <label for="modifier_specialisation_niveau" class="form-label">Nouveau niveau (%)</label>
                        <input type="range" class="form-range" id="modifier_specialisation_niveau" name="modifier_specialisation_niveau" min="0" max="100" step="5" oninput="this.nextElementSibling.value = this.value + '%'">
                        <output>50%</output>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modifierCarriereModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier une Expérience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="modifierinformation.php">
                    <div class="mb-3">
                        <label for="modifierCarriereModal" class="form-label">Sélectionner l'expérience à modifier</label>
                        <select class="form-select" id="modifierCarriereModal" name="modifierCarriereModal" required>
                            <?php foreach ($carrieres as $car): ?>
                                <option value="<?= htmlspecialchars($car['id_carreire']); ?>">
                                    <?= htmlspecialchars($car['club']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modifier_carriere_club" class="form-label">Nouveau nom du club</label>
                        <input type="text" class="form-control" id="modifier_carriere_club" name="modifier_carriere_club">
                    </div>
                    <div class="mb-3">
                        <label for="modifier_carriere_description" class="form-label">Nouvelle description</label>
                        <textarea class="form-control" id="modifier_carriere_description" name="modifier_carriere_description" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-box about-widget">
                    <h2 class="widget-title">À propos de mon profil</h2>
                    <p>Découvrez mon parcours professionnel, mes compétences et mes réalisations. Je suis passionné par mon domaine et toujours à la recherche de nouveaux défis.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-box get-in-touch">
                    <h2 class="widget-title">Me contacter</h2>
                    <ul>
                        <li>Localisé à : [Votre ville/région]</li>
                        <li>contact@monprofil.com</li>
                        <li>+212 6 XX XX XX XX</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-box pages">
                    <h2 class="widget-title">Navigation</h2>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="about.php">À propos</a></li>
                        <li><a href="entraineur.php">Mon Profil</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-box subscribe">
                    <h2 class="widget-title">Restons connectés</h2>
                    <p>Abonnez-vous pour recevoir mes dernières mises à jour et actualités professionnelles.</p>
                    <form action="index.php">
                        <input type="email" placeholder="Votre email">
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>
</body>
</html>