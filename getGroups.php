
<?php
include 'connexion.php';

if ($_GET['action'] == 'getTimetable') {
    $group_id = $_GET['group_id'];
    $stmt = $pdo->prepare("SELECT * FROM timetable WHERE group_id = ? ORDER BY day, time_slot");
    $stmt->execute([$group_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
?>
