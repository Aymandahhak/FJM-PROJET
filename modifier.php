    <?php
    require_once 'connecter.php'; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        $player_id = intval($_POST['player_id']);
        $status = $_POST['status']; 
        $physical_condition = intval($_POST['physical_condition']);
        $performance = intval($_POST['performance']);

        try {
            // Prepare SQL statement to update player information
            $stmt = $pdo->prepare("UPDATE joueurs SET status = ?, physical_condition = ?, performance = ? WHERE id = ?");

            // Bind parameters 
            $stmt->bindValue(1, $status, PDO::PARAM_STR);
            $stmt->bindValue(2, $physical_condition, PDO::PARAM_INT);
            $stmt->bindValue(3, $performance, PDO::PARAM_INT);
            $stmt->bindValue(4, $player_id, PDO::PARAM_INT);
            if ($stmt->execute()) {

                header("Location: suiviejoueurs.php?success=1");
                exit();
            } else {
                // Handle execution error
                header("Location: suiviejoueurs.php?error=1");
                exit();
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            header("Location: suiviejoueurs.php?error=2");
            exit();
        }
    } else {
        header("Location: suiviejoueurs.php");
        exit();
    }
    ?>