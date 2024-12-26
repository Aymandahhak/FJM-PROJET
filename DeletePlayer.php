<?php
require('connecter.php');

// Gestion de la suppression des joueurs
if (isset($_GET['delete_player'])) {
    $playerId = intval($_GET['delete_player']); // Assurez-vous que l'ID est un entier
    try {
        $stmt = $pdo->prepare("DELETE FROM joueurs WHERE id = :id");
        $stmt->bindParam(':id', $playerId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "<script>alert('Le joueur a été supprimé avec succès.');</script>";
            echo "<script>window.location.href = 'indexAdmin.php';</script>"; // Redirection
        } else {
            echo "<script>alert('Une erreur est survenue lors de la suppression du joueur.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erreur : " . $e->getMessage() . "');</script>";
    }
}
?>
