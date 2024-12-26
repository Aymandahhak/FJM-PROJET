<?php
<<<<<<< HEAD
require('connecter.php');
=======
require('connexion.php');
>>>>>>> 2ca880c697b949a046a87fc3152fd0e976802fe6
session_start();

$user_name = $_SESSION['nom']; // User's name
// $user_email = $_SESSION['email']; // User's email

// Fetch notifications, messages, and emails from your database
// Example:
$notifications = getNotifications(); // This function should fetch notifications from your database
$messages = getMessages(); // Fetch messages
$emails = getEmails(); // Fetch emails
$unread_notifications_count = count($notifications);
$unread_messages_count = count($messages);
$unread_emails_count = count($emails);

// Function examples (you need to implement these functions to query your database)
function getNotifications()
{
    // SQL query to fetch notifications
    return []; // Example, return a list of notifications
}

function getMessages()
{
    // SQL query to fetch messages
    return []; // Example, return a list of messages
}

function getEmails()
{
    // SQL query to fetch emails
    return []; // Example, return a list of emails
}

class Cours
{
    private $id;
    private $heure; 
    private $matieres; 

    public static function creerBaseDeDonnees()
    {
        try {
            $pdo = new PDO('mysql:host=localhost', 'root', '');
            $pdo->exec("CREATE DATABASE IF NOT EXISTS projetg");
            $pdo->exec("USE projetg");
            $pdo->exec("CREATE TABLE IF NOT EXISTS cours (
                id INT AUTO_INCREMENT PRIMARY KEY,
                heure VARCHAR(100),
                courLundi VARCHAR(100),
                courMardi VARCHAR(100),
                courMercredi VARCHAR(100),
                courJeudi VARCHAR(100),
                courVendredi VARCHAR(100),
                courSamedi VARCHAR(100)
            )");
        } catch (PDOException $e) {
            echo "Database creation failed: " . $e->getMessage();
        }
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setHeure($heure)
    {
        $this->heure = $heure;
    }

    public function setMatiere($matieres)
    {
        $this->matieres = $matieres;
    }

    public function enregistrer()
    {
        self::creerBaseDeDonnees();
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=projetg', 'root', '');
            $stmt = $pdo->prepare('UPDATE cours SET heure = ?, courLundi = ?, courMardi = ?, courMercredi = ?, courJeudi = ?, courVendredi = ?, courSamedi = ? WHERE id = ?');
            $stmt->execute([
                $this->heure, $this->matieres[0], $this->matieres[1], $this->matieres[2],
                $this->matieres[3], $this->matieres[4], $this->matieres[5], $this->id
            ]);
        } catch (PDOException $e) {
            echo "Update failed: " . $e->getMessage();
        }
    }

    public function recupererCours()
    {
        self::creerBaseDeDonnees();
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=projetg', 'root', '');
            $stmt = $pdo->query('SELECT * FROM cours');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Fetch failed: " . $e->getMessage();
        }
    }

    public function ajouter()
    {
        self::creerBaseDeDonnees();
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=projetg', 'root', '');
            $stmt = $pdo->prepare('INSERT INTO cours (heure, courLundi, courMardi, courMercredi, courJeudi, courVendredi, courSamedi) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                "", "", "", "", "", "", ""
            ]);
        } catch (PDOException $e) {
            echo "Insert failed: " . $e->getMessage();
        }
    }

    public function supprimerLigne($id)
    {
        self::creerBaseDeDonnees();
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=projetg', 'root', '');
            $stmt = $pdo->prepare('DELETE FROM cours WHERE id = ?');
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo "Delete failed: " . $e->getMessage();
        }
    }
}
?>

?>






<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <!-- Avoid repeating CSS links for Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- <script src="addMemberButton.js"></script> -->
    <style>
        /* Styles for admin mode transition */
        .form-check-label {
            transition: color 0.3s, transform 0.3s;
        }

        /* Styles for active admin mode */
        .form-check-input:checked~.form-check-label {
            color: yellow;
            /* Change the desired color */
            transform: rotate(360deg);
            /* Change the desired animation */
        }

        input {
            box-shadow: none !important;
            outline: none !important;
        }
    </style>
</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
<<<<<<< HEAD
                        <a class="logo" href="indexAdmin.php">
                            <a class="navbar-brand ps-3" href="indexAdmin.php"> <img src="images/logo.png" alt="" width="180px"> </a>
=======
                        <a class="logo" href="index.php">
                            <a class="navbar-brand ps-3" href="index.php"> <img src="images/logo.png" alt="" width="180px"> </a>
>>>>>>> 2ca880c697b949a046a87fc3152fd0e976802fe6
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
<<<<<<< HEAD
                                    <a href="indexAdmin.php">Dashboard 1</a>
=======
                                    <a href="index.php">Dashboard 1</a>
>>>>>>> 2ca880c697b949a046a87fc3152fd0e976802fe6
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="chart.php">
                                <i class="fas fa-chart-bar"></i>Charts</a>
                        </li>
                        <li>
                            <a href="table.php">
                                <i class="fas fa-table"></i>Tables</a>
                        </li>

                        <li>
                            <a href="EmploiTemps.php">
                                <i class="fas fa-schedules-alt"></i>Schedules</a>
                        </li>

                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Pages</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
<<<<<<< HEAD
                                    <a href="loginAdmin.php">Login</a>
=======
                                    <a href="login.php">Login</a>
>>>>>>> 2ca880c697b949a046a87fc3152fd0e976802fe6
                                </li>
                                <li>
                                    <a href="register.php">Register</a>
                                </li>
                                <li>
                                    <a href="forget-pass.php">Forget Password</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                    </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->







      <!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
<<<<<<< HEAD
            <a class="navbar-brand ps-3" href="indexAdmin.php"> <img src="images/logo.png" alt="" width="180px"> </a>
=======
            <a class="navbar-brand ps-3" href="index.php"> <img src="images/logo.png" alt="" width="180px"> </a>
>>>>>>> 2ca880c697b949a046a87fc3152fd0e976802fe6
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="active has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
<<<<<<< HEAD
                            <a href="indexAdmin.php">Dashboard 1</a>
=======
                            <a href="index.php">Dashboard 1</a>
>>>>>>> 2ca880c697b949a046a87fc3152fd0e976802fe6
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="chart.php">
                        <i class="fas fa-chart-bar"></i>Charts</a>
                </li>
                <li>
                    <a href="table.php">
                        <i class="fas fa-table"></i>Tables</a>
                </li>
                <li>
                    <a href="EmploiTemps.php">
                        <i class="fas fa-schedules-alt"></i>Schedules</a>
                </li>
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-copy"></i>Pages</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
<<<<<<< HEAD
                            <a href="loginAdmin.php">Login</a>
=======
                            <a href="login.php">Login</a>
>>>>>>> 2ca880c697b949a046a87fc3152fd0e976802fe6
                        </li>
                        <li>
                            <a href="register.php">Register</a>
                        </li>
                        <li>
                            <a href="forget-pass.php">Forget Password</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->

<!-- PAGE CONTAINER-->
<div class="page-container">
    <!-- HEADER DESKTOP-->
    <header class="header-desktop">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="header-wrap">
                    <!-- Search form -->
                    <form class="form-header" action="search_results.php" method="POST">
                        <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                        <button class="au-btn--submit" type="submit">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </form>
                    <div class="header-button">
                        <!-- Notifications -->
                        <div class="noti-wrap">
                            <div class="noti__item js-item-menu">
                                <i class="zmdi zmdi-comment-more"></i>
                                <span class="quantity"><?php echo $unread_messages_count; ?></span>
                                <div class="mess-dropdown js-dropdown">
                                    <div class="mess__title">
                                        <p>You have <?php echo $unread_messages_count; ?> new message<?php echo $unread_messages_count > 1 ? 's' : ''; ?></p>
                                    </div>
                                    <?php foreach ($messages as $message): ?>
                                        <div class="mess__item">
                                            <div class="image img-cir img-40">
                                                <img src="images/icon/avatar-06.jpg" alt="<?php echo htmlspecialchars($message['sender']); ?>" />
                                            </div>
                                            <div class="content">
                                                <h6><?php echo htmlspecialchars($message['sender']); ?></h6>
                                                <p><?php echo htmlspecialchars($message['content']); ?></p>
                                                <span class="time"><?php echo htmlspecialchars($message['timestamp']); ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="mess__footer">
                                        <a href="#">View all messages</a>
                                    </div>
                                </div>
                            </div>

                                  <!-- Emails -->
<div class="noti__item js-item-menu">
    <i class="zmdi zmdi-email"></i>
    <span class="quantity"><?php echo $unread_emails_count; ?></span>
    <div class="email-dropdown js-dropdown">
        <div class="email__title">
            <p>You have <?php echo $unread_emails_count; ?> new email<?php echo $unread_emails_count > 1 ? 's' : ''; ?></p>
        </div>
        <?php foreach ($emails as $email): ?>
            <div class="email__item">
                <div class="image img-cir img-40">
                    <img src="images/icon/avatar-06.jpg" alt="Cynthia Harvey" />
                </div>
                <div class="content">
                    <p><?php echo htmlspecialchars($email['subject']); ?></p>
                    <span><?php echo htmlspecialchars($email['sender']); ?>, <?php echo htmlspecialchars($email['timestamp']); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="email__footer">
            <a href="#">See all emails</a>
        </div>
    </div>
</div>
<!-- Notifications -->
<div class="noti__item js-item-menu">
    <i class="zmdi zmdi-notifications"></i>
    <span class="quantity"><?php echo $unread_notifications_count; ?></span>
    <div class="notifi-dropdown js-dropdown">
        <div class="notifi__title">
            <p>You have <?php echo $unread_notifications_count; ?> notification<?php echo $unread_notifications_count > 1 ? 's' : ''; ?></p>
        </div>
        <?php foreach ($notifications as $notification): ?>
            <div class="notifi__item">
                <div class="bg-c1 img-cir img-40">
                    <i class="zmdi zmdi-email-open"></i>
                </div>
                <div class="content">
                    <p><?php echo htmlspecialchars($notification['message']); ?></p>
                    <span class="date"><?php echo htmlspecialchars($notification['timestamp']); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="notifi__footer">
            <a href="#">All notifications</a>
        </div>
    </div>
</div>
</div>
<!-- Account Menu -->
<div class="account-wrap">
    <div class="account-item clearfix js-item-menu">
        <div class="image">
            <img src="images/icon/avatar-01.jpg" alt="John Doe" />
        </div>
        <div class="content">
            <a class="js-acc-btn" href="#"><?php echo htmlspecialchars($user_name); ?></a>
        </div>
        <div class="account-dropdown js-dropdown">
            <div class="info clearfix">
                <div class="image">
                    <a href="#">
                        <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                    </a>
                </div>
                <div class="content">
                    <h5 class="name">
                        <a href="#"><?php echo htmlspecialchars($user_name); ?></a>
                    </h5>
                    <span class="email"><?php echo htmlspecialchars($user_email); ?></span>
                </div>
            </div>
            <div class="account-dropdown__body">
                <div class="account-dropdown__item">
                    <a href="account.php">
                        <i class="zmdi zmdi-account"></i>Account</a>
                </div>
                <div class="account-dropdown__item">
                    <a href="setting.php">
                        <i class="zmdi zmdi-settings"></i>Setting</a>
                </div>
            </div>
            <div class="account-dropdown__footer">
<<<<<<< HEAD
                <a href="logoutAdmin.php">
=======
                <a href="logout.php">
>>>>>>> 2ca880c697b949a046a87fc3152fd0e976802fe6
                    <i class="zmdi zmdi-power"></i>Logout</a>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</header>
<!-- HEADER DESKTOP-->

<!-- MAIN CONTENT-->
<body style="background-image: url('paper.png');">

    <!-- MAIN CONTENT -->
    <header class="bg-dark fw-bold text-light p-3 mb-5">
        <div class="form-check form-switch m-2 d-flex justify-content-center cursor-pointer">
            <input class="form-check-input me-1" type="checkbox" id="toggleButton">
            <label class="form-check-label" for="toggleButton">Basculer en mode admin</label>
        </div>
    </header>

    <!-- Schedule Display -->
    <div class="container d-flex justify-content-center align-items-center table-responsive">
<<<<<<< HEAD
        <form method="post" action="indexAdmin.php">
=======
        <form method="post" action="index.php">
>>>>>>> 2ca880c697b949a046a87fc3152fd0e976802fe6
            <div class="d-flex justify-content-center">
                <div class="mb-5 d-none" id="ajouterLigne">
                    <button class="btn btn-primary me-2" title="Ajouter une ligne et insérer des matières et horaires" name="ajouter">Ajouter ligne</button>
                    <?php
                    if (isset($_POST['ajouter'])) {
                        // Le bouton "ajouter" a été cliqué
                        $cours = new Cours(); // On crée une instance de Cours
                        $cours->ajouter(); // On appelle la méthode ajouter
                    }
                    ?>
                </div>
            </div>

            <table class="table">
                <tr>
                    <td class="p-0"><input readonly placeholder="" type="text" class="form-control bg-white fw-bold rounded-0 d-none"></td>
                    <td class="p-0"><input readonly value="Lundi" type="text" class="form-control bg-white fw-bold rounded-0"></td>
                    <td class="p-0"><input readonly value="Mardi" type="text" class="form-control bg-white fw-bold rounded-0"></td>
                    <td class="p-0"><input readonly value="Mercredi" type="text" class="form-control bg-white fw-bold rounded-0"></td>
                    <td class="p-0"><input readonly value="Jeudi" type="text" class="form-control bg-white fw-bold rounded-0"></td>
                    <td class="p-0"><input readonly value="Vendredi" type="text" class="form-control bg-white fw-bold rounded-0"></td>
                    <td class="p-0"><input readonly value="Samedi" type="text" class="form-control bg-white fw-bold rounded-0"></td>
                </tr>
                <tr id="exempleLigne" class="d-none">
                    <td class="p-0"><input readonly placeholder="ex: 8h - 9h" type="text" class="form-control rounded-0"></td>
                    <td class="p-0"><input readonly placeholder="ex: Maths" type="text" class="form-control rounded-0"></td>
                    <td class="p-0"><input readonly placeholder="ex: Anglais" type="text" class="form-control rounded-0"></td>
                    <td class="p-0"><input readonly placeholder="ex: Physique" type="text" class="form-control rounded-0"></td>
                    <td class="p-0"><input readonly placeholder="ex: Français" type="text" class="form-control rounded-0"></td>
                    <td class="p-0"><input readonly placeholder="ex: Chimie" type="text" class="form-control rounded-0"></td>
                    <td class="p-0"><input readonly placeholder="ex: Dessin" type="text" class="form-control rounded-0"></td>
                </tr>
                <?php
                $cours = new Cours(); // On crée une instance de Cours
                $resultats = $cours->recupererCours(); // On appelle la méthode pour avoir tous les enregistrements en BDD

                if (count($resultats) > 0) {
                    // A l'aide d'une boucle, on affiche tous ces enregistrements dans ce format
                    foreach ($resultats as $resultat) {
                        echo "<tr class='entrerValeur'>";
                        echo "<td class='p-0'><input readonly name='heure[]' value=\"" . $resultat['heure'] . "\" type='text' class='form-control bg-white rounded-0'></td>";
                        echo "<td class='p-0'><input readonly name='courDuLundi[]' value=\"" . $resultat['courLundi'] . "\" type='text' class='form-control bg-white rounded-0'></td>";
                        echo "<td class='p-0'><input readonly name='courDuMardi[]' value=\"" . $resultat['courMardi'] . "\" type='text' class='form-control bg-white rounded-0'></td>";
                        echo "<td class='p-0'><input readonly name='courDuMercredi[]' value=\"" . $resultat['courMercredi'] . "\" type='text' class='form-control bg-white rounded-0'></td>";
                        echo "<td class='p-0'><input readonly name='courDuJeudi[]' value=\"" . $resultat['courJeudi'] . "\" type='text' class='form-control bg-white rounded-0'></td>";
                        echo "<td class='p-0'><input readonly name='courDuVendredi[]' value=\"" . $resultat['courVendredi'] . "\" type='text' class='form-control bg-white rounded-0'></td>";
                        echo "<td class='p-0'><input readonly name='courDuSamedi[]' value=\"" . $resultat['courSamedi'] . "\" type='text' class='form-control bg-white rounded-0'></td>";
                        echo "<td class='p-0 d-none afficheAdmin'><button title='supprimer la ligne' class='btn btn-outline-danger' value='" . $resultat['id'] . "' name='supprimer'><i class='bi bi-x-lg'></i></button></td>";
                        echo "<td class='p-0 d-none afficheAdmin'><button title='enregistrer la ligne' class='btn btn-outline-success' value='" . $resultat['id'] . "' name='modifier'><i class='bi bi-save2'></i></button></td>";
                        echo "<input class='d-none' type='hidden' name='id[]' value='" . $resultat['id'] . "'>";
                        echo "</tr>";
                    }

                    // Pour supprimer une ligne
                    if (isset($_POST['supprimer'])) {
                        $id = $_POST['supprimer'];
                        // Appeler la méthode supprimerLigne en passant $id comme paramètre
                        $cours->supprimerLigne($id);
                    }

                    // Pour modifier la ligne
                    if (isset($_POST['modifier'])) {
                        $ids = $_POST['id'];
                        $heures = $_POST['heure'];
                        $courDuLundi = $_POST['courDuLundi'];
                        $courDuMardi = $_POST['courDuMardi'];
                        $courDuMercredi = $_POST['courDuMercredi'];
                        $courDuJeudi = $_POST['courDuJeudi'];
                        $courDuVendredi = $_POST['courDuVendredi'];
                        $courDuSamedi = $_POST['courDuSamedi'];

                        foreach ($ids as $key => $id) {
                            $cours = new Cours();
                            $cours->setId($id);
                            $cours->setHeure($heures[$key]);
                            $cours->setMatiere([$courDuLundi[$key], $courDuMardi[$key], $courDuMercredi[$key], $courDuJeudi[$key], $courDuVendredi[$key], $courDuSamedi[$key]]);

                            $cours->enregistrer(); // Save updated data
                        }
                    }
                }
                ?>
            </table>
        </form>
    </div>

</body>

<script>
    document.getElementById('addRowBtn').addEventListener('click', function () {
        var table = document.getElementById('scheduleTable').getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();
        
        for (var i = 0; i < 7; i++) {
            var newCell = newRow.insertCell(i);
            var input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control rounded-0';
            newCell.appendChild(input);
        }
        // Add hidden fields and buttons for save and delete functionalities
        var hiddenId = document.createElement('input');
        hiddenId.type = 'hidden';
        hiddenId.name = 'id[]';
        newRow.appendChild(hiddenId);

        var deleteCell = newRow.insertCell(7);
        deleteCell.className = 'p-0 d-none afficheAdmin';
        var deleteBtn = document.createElement('button');
        deleteBtn.type = 'submit';
        deleteBtn.className = 'btn btn-outline-danger';
        deleteBtn.name = 'supprimer';
        deleteBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
        deleteCell.appendChild(deleteBtn);

        var saveCell = newRow.insertCell(8);
        saveCell.className = 'p-0 d-none afficheAdmin';
        var saveBtn = document.createElement('button');
        saveBtn.type = 'submit';
        saveBtn.className = 'btn btn-outline-success';
        saveBtn.name = 'modifier';
        saveBtn.innerHTML = '<i class="bi bi-save2"></i>';
        saveCell.appendChild(saveBtn);
    });
</script>

</div>
</div>

<!-- Jquery JS-->
<script src="vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="vendor/bootstrap-4.1/popper.min.js"></script>
<script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor JS -->
<script src="vendor/slick/slick.min.js"></script>
<script src="vendor/wow/wow.min.js"></script>
<script src="vendor/animsition/animsition.min.js"></script>
<script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<script src="vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="vendor/counter-up/jquery.counterup.min.js"></script>
<script src="vendor/circle-progress/circle-progress.min.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="vendor/chartjs/Chart.bundle.min.js"></script>
<script src="vendor/select2/select2.min.js"></script>

<!-- <script src="addMemberButton.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript to toggle form visibility
    const toggleButton = document.getElementById('toggleFormButton');
    const formContainer = document.getElementById('formContainer');

    toggleButton.addEventListener('click', () => {
        if (formContainer.classList.contains('d-none')) {
            formContainer.classList.remove('d-none');
            // toggleButton.textContent = 'Hide Form';
        } else {
            formContainer.classList.add('d-none');
            // toggleButton.textContent = 'Show Form';
        }
    });
</script>
<!-- Main JS-->
<script src="js/main.js"></script>
<script src="EmploiTemps.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<!-- end document-->
