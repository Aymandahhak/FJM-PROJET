<?php
require_once "connecter.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

$coachId = $_SESSION['user_id'];


// Modifier un diplôme
if (!empty($_POST['modifier_diplome_selection']) && !empty($_POST['modifier_diplome_titre']) && !empty($_POST['modifier_diplome_annee'])) {
    $diplomeId = ($_POST['modifier_diplome_selection']);
    $titre = ($_POST['modifier_diplome_titre']);
    $annee = ($_POST['modifier_diplome_annee']);

    try {
        $stmt = $pdo->prepare("UPDATE diplomes SET titre = ?, annee = ? WHERE id = ?");
        $stmt->execute([$titre, $annee, $diplomeId]);
        header('Location: entraineur.php?success=update');
    } catch (PDOException $e) {
        die("Erreur SQL : " . $e->getMessage());
    }
}


// Modifier d'une spécialisation
if (!empty($_POST['modifier_specialisation_selection']) && !empty($_POST['modifier_specialisation_nom']) && !empty($_POST['modifier_specialisation_niveau'])) {
    try {
        $stmt = $pdo->prepare("UPDATE  specialisations SET nom = ?, progression = ? where id = ? ");
        $stmt->execute([
            $_POST['modifier_specialisation_nom'],
            $_POST['modifier_specialisation_niveau'],
            $_POST['modifier_specialisation_selection']
        ]);
        header('Location: entraineur.php?success=specialisation');
        exit();
    } catch(PDOException $e) {
        header('Location: entraineur.php?error=specialisation');
        exit();
    }
}

// Modifier d'une carrière
if (!empty($_POST['modifier_carriere_club']) && !empty($_POST['modifier_carriere_description'])) {
    try {
        $stmt = $pdo->prepare("UPDATE carreires SET club = ?, description = ? where id = ? ");
        $stmt->execute([
            $_POST['modifier_carriere_club'],
            $_POST['modifier_carriere_description'],
            $_POST['modifier_carriere_selection']
            
        ]);
        header('Location: entraineur.php?success=carriere');
        exit();
    } catch(PDOException $e) {
        header('Location: entraineur.php?error=carriere');
        exit();
    }
}


header('Location: entraineur.php');
exit();
?>