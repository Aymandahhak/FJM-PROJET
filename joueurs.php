<?php
// Fonction pour récupérer tous les joueurs avec un filtre
function getAllPlayers($filter = null, $coachId = null) {
    global $pdo;
    try {
        $query = "SELECT * FROM joueurs WHERE id_entraineur = :coach_id";
        
        // Préparation des conditions de filtrage
        $conditions = [];
        $params = [':coach_id' => $coachId];

        // Filtrage par statut
        if ($filter && $filter !== 'all') {
            if (in_array($filter, ['active', 'blessee', 'repos'])) {
                $conditions[] = "status = :status";
                $params[':status'] = $filter;
            }
        }

        // Ajout des conditions à la requête
        if (!empty($conditions)) {
            $query .= " AND " . implode(" AND ", $conditions);
        }

        $query .= " ORDER BY performance DESC";

        // Préparation de la requête
        $stmt = $pdo->prepare($query);

        // Liaison des paramètres
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, 
                is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR
            );
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur : " . $e->getMessage());
        return [];
    }
}


function getStatistics($coachId = null) {
    global $pdo;
    try {
        $stats = [];
        // Nombre de joueurs actifs de l'entraîneur
        $stmt = $pdo->prepare("SELECT COUNT(*) AS active_players FROM joueurs WHERE status = 'active' AND id_entraineur = :entraineur_id");
        $stmt->execute(['entraineur_id' => $coachId]);
        $stats['active_players'] = $stmt->fetchColumn();

        // Nombre de joueurs blessés de l'entraîneur
        $stmt = $pdo->prepare("SELECT COUNT(*) AS injured_players FROM joueurs WHERE status = 'blessee' AND id_entraineur = :entraineur_id");
        $stmt->execute(['entraineur_id' => $coachId]);
        $stats['injured_players'] = $stmt->fetchColumn();

        // Nombre de joueurs en repos de l'entraîneur
        $stmt = $pdo->prepare("SELECT COUNT(*) AS repos_player FROM joueurs WHERE status = 'repos' AND id_entraineur = :entraineur_id");
        $stmt->execute(['entraineur_id' => $coachId]);
        $stats['repos_player'] = $stmt->fetchColumn();

        // Performance moyenne des joueurs de l'entraîneur
        $stmt = $pdo->prepare("SELECT AVG(performance) AS avg_performance FROM joueurs WHERE id_entraineur = :entraineur_id");
        $stmt->execute(['entraineur_id' => $coachId]);
        $stats['avg_performance'] = round($stmt->fetchColumn(), 0);

        return $stats;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return [];
    }
}

// Fonction pour calculer la couleur de la barre de progression en fonction de la performance
function getProgressBarColor($value) {
    if ($value >= 80) return 'bg-success';
    if ($value >= 50) return 'bg-warning';
    return 'bg-danger';
}

function formatPercentage($percentage) {
    return number_format($percentage, 0) . '%';
}




function getPlayerById($player_id) {
    global $pdo;  // Assuming $conn is a PDO connection object
    
    $query = "SELECT id, nom, position, status, physical_condition, performance FROM joueurs WHERE id = :player_id";
    
    // Prepare the statement using PDO
    $stmt = $pdo->prepare($query);
    
    // Bind the player_id parameter
    $stmt->bindParam(':player_id', $player_id, PDO::PARAM_INT);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch the result
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function getPlayerStatus($player) {
    switch ($player['status']) {
        case 'active':
            return 'Actif';
        case 'blessee':
            return 'Blessé';
        case 'repos':
            return 'En repos';
        default:
            return 'Statut inconnu';
    }
}

?>





