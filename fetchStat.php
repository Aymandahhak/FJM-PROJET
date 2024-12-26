<?php
// Fetch statistics
$totalPlayers = $pdo->query("SELECT COUNT(*) FROM joueurs")->fetchColumn();
$activeFormations = $pdo->query("SELECT COUNT(*) FROM formations WHERE status = 'active'")->fetchColumn();
$totalAdmins = $pdo->query("SELECT COUNT(*) FROM members ")->fetchColumn();
$validatedDocsPercentage = 75;