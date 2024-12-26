<?php
session_start();
require('connecter.php');
include('DeletePlayer.php');
include('fetchStat.php');
include('AddPlayer.php');
include('AddMembre.php');
include('AddAdmin.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header('Location: connexion.php');
    exit();
}

// Récupérer les détails de l'utilisateur
$user_name = $_SESSION['user']; // Nom de l'utilisateur
$user_email = $_SESSION['email']; // Email de l'utilisateur

// Fetch player data
$stmt = $pdo->query("SELECT * FROM joueurs");
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Member data
$stmt = $pdo->query("SELECT * FROM members");
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT COUNT(*) AS total FROM members");
$countMember = $stmt->fetch(PDO::FETCH_ASSOC);
$totalMembers = $countMember['total']; // Total des membres

// Fetch ADMIN data
$stmt = $pdo->query("SELECT * FROM admins");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT COUNT(*) AS total FROM admins");
$countAdmins = $stmt->fetch(PDO::FETCH_ASSOC);
$totalAdmins = $countAdmins['total']; // Total des administrateurs
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
    <!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all"> -->

    <!-- Fontfaces CSS -->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- ZMDI CSS -->
    <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link href="mystyle.css" rel="stylesheet" media="all">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="addMemberButton.js"></script>
    <style>.js-sub-list {
    display: none;
}

.has-sub.show-sub .js-sub-list {
    display: block;
}</style>
</head>
<body class="animsition">
    <div class="page-wrapper">
            <!-- HEADER MOBILE-->
            <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="indexAdmin.php">
                            <a class="navbar-brand ps-3" href="indexAdmin.php"> <img src="images/logo.png" alt="" width="180px"> </a>
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
                                    <a href="indexAdmin.php">Dashboard 1</a>
                                </li>
                            </ul>
                        </li>
                       
                        <li>
                            <a href="chart.php">
                                <i class="fas fa-chart-bar"></i>Charts</a>
                        </li>
                        <li>
                            <a href="tables.php">
                                <i class="fas fa-table"></i>Add Players</a>
                        </li>

                        <li>
    <a href="EmploiTemps.php">
        <i class="mdi mdi-calendar-clock"></i>Schedules</a>
</li>

                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Pages</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="connexion.php">Login</a>
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
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <a class="navbar-brand ps-3" href="indexAdmin.php"> <img src="images/logo.png" alt="" width="180px"> </a>
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="active has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="indexAdmin.php">Dashboard 1</a>
                        </li>
                    </ul>
                </li>
                <li>
                            <a href="index.php">
                                <i class="bi bi-house-door-fill"></i>Home</a>
</li>
                <li>
                    <a href="chart.php">
                        <i class="fas fa-chart-bar"></i>Charts
                    </a>
                </li>
                <li>
                    <a href="tables.php">
                        <i class="fas fa-table"></i>Add Players
                    </a>
                </li>
                <li>
                    <a href="EmploiTemps.php">
                        <i class="bi bi-table"></i>Schedules
                    </a>
                </li>
              
                <!-- Dropdown Menu for Pages -->
                <li class="nav-item dropdown has-sub">
                    <a class="nav-link dropdown-toggle js-arrow" href="#" id="pagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-copy"></i> Pages
                    </a>
                    <ul class="dropdown-menu list-unstyled navbar__sub-list js-sub-list" aria-labelledby="pagesDropdown">
                        <li><a class="dropdown-item" href="connexion.php">Login</a></li>
                        <li><a class="dropdown-item" href="register.php">Register</a></li>
                        <li><a class="dropdown-item" href="forget-pass.php">Forget Password</a></li>
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
                                <i class="bi bi-search"></i>
                                </button>
                            </form>
                            <div class="header-button">
                              
                                  
                                <!-- Account Menu -->
                                 
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                           <img src="<?php echo htmlspecialchars($admin['image']); ?>" alt="John Smith">
                                        </div>
                                        <div class="content">
                                            
                                            <a ><?php echo htmlspecialchars($user_name); ?></a>
                                            <i class="bi bi-menu-down"></i>
                                        </div>
                                        
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                            <div class="image">
    <a href="#">
        <img src="<?php echo htmlspecialchars($admin['image']); ?>" alt="John Smith">
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
            <i class="bi bi-person-circle"></i>Account</a>
    </div>
    <div class="account-dropdown__item">
        <a href="setting.php">
            <i class="bi bi-gear"></i>Setting</a>
    </div>
</div>
<div class="account-dropdown__footer">
    <a href="logoutAdmin.php">
        <i class="bi bi-box-arrow-left"></i>Logout</a>
</div>
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
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">overview</h2>
                                    <!-- <button class="au-btn au-btn-icon au-btn--blue">
                                        <i class="zmdi zmdi-plus"></i>add item</button>
                                </div> -->
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="mdi mdi-run"></i>
                                            </div>
                                            <div class="text">
                                                <h2><?php echo $totalPlayers; ?></h2>
                                                <span>Players</span>
                                            </div>
                                        </div>
                                        <div class="links">
                                            <a href="">view more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon ">
                                                <i class="mdi mdi-school"></i>
                                            </div>


                                            <div class="text">
                                                <h2><?php echo $activeFormations ?></h2>
                                                <span>Formations</span>
                                            </div>
                                        </div>
                                        <div class="links">
                                            <a href="">view more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="mdi mdi-account-tie"></i>
                                            </div>

                                            <div class="text">
                                                <h2><?php echo $totalAdmins ?></h2>
                                                <span>Administartion</span>
                                            </div>
                                        </div>
                                        <div class="links">
                                            <a href="">view more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="mdi mdi-file-document"></i>
                                            </div>

                                            <div class="text">
                                                <h2><?php echo $validatedDocsPercentage ?></h2>
                                                <span>Documents</span>
                                            </div>
                                        </div>
                                        <div class="links text-light">
                                            <a href="">view more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                    <div class="col-lg-12">
                        <div class="au-card recent-report">
                            <div class="au-card-inner">
                                <h3 class="title-2">recent reports</h3>
                                <div class="chart-info">
                                    <div class="chart-info__left">
                                        <div class="chart-note">
                                            <span class="dot dot--blue"></span>
                                            <span>products</span>
                                        </div>
                                        <div class="chart-note mr-0">
                                            <span class="dot dot--green"></span>
                                            <span>services</span>
                                        </div>
                                    </div>
                                    <div class="chart-info__right">
                                        <div class="chart-statis">
                                            <span class="index incre">
                                                <i class="zmdi zmdi-long-arrow-up"></i>25%</span>
                                            <span class="label">products</span>
                                        </div>
                                        <div class="chart-statis mr-0">
                                            <span class="index decre">
                                                <i class="zmdi zmdi-long-arrow-down"></i>10%</span>
                                            <span class="label">services</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="recent-report__chart">
                                    <canvas id="recent-rep-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div> -->
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="title-1 m-b-25">Players</h2>

                                <!-- Search and Row Filter in Two Columns -->
                                <div class="row mb-3">
                                    <!-- Search Input -->
                                    <div class="col-6">
                                        <label for="datatable-input">Search:</label>
                                        <input id="datatable-input" class="datatable-input form-control" placeholder="Search..." type="search"
                                            title="Search within table" aria-controls="players-table">
                                    </div>

                                    <!-- Row Filter -->
                                    <div class="col-6">
                                        <label for="datatable-selector">Show rows:</label>
                                        <select id="datatable-selector" class="datatable-selector form-control">
                                            <option value="5">5</option>
                                            <option value="10" selected="">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning" id="players-table">
                                        <thead>
                                            <tr>
                                    <th>#</th>
                                                <th>Name</th>
                                                <th>Age</th>
                                                <th>Position</th>
                                                <th>Action</th>
                                                <!-- <th>date</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($players as $index => $player): ?>
                                                <tr>
                                                    <td><?php echo $index + 1; ?></td>
                                                    <td><?php echo htmlspecialchars($player['nom']); ?></td>
                                                    <td><?php echo htmlspecialchars($player['age']); ?></td>
                                                    <td><?php echo htmlspecialchars($player['position']); ?></td>
                                                    <td>
                                                        <a href="?delete_player=<?php echo $player['id']; ?>" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?');">
                                                            Supprimer
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="row">
    <div class="col-lg-7">
        <!-- Left Section -->
        <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
            <div class="au-card-title" style="background-image:url('images/bg-title-02.jpg');">
                <div class="bg-overlay bg-overlay--blue"></div>
                <h3>
                    <i class="zmdi zmdi-comment-text"></i>Members
                </h3>
                <button id="toggleFormButton" class="au-btn-plus">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>

            <div class="au-inbox-wrap js-inbox-wrap">
                <div class="au-message js-list-load">
                    <div class="au-message__noti">
                        <p>There are
                            <span><?php echo htmlspecialchars($totalMembers, ENT_QUOTES, 'UTF-8'); ?></span>
                            Members
                        </p>
                    </div>
                </div>
            </div>

            <!-- Members List -->
            <?php foreach ($members as $index => $member): ?>
            <div class="au-message__item unread">
                <div class="au-message__item-inner">
                    <div class="au-message__item-text">
                        <div class="avatar-wrap">
                            <div class="avatar">
                                <img src="<?php echo htmlspecialchars($member['image']); ?>" alt="John Smith">
                            </div>
                        </div>
                        <div class="text">
                            <h5 class="name"><?php echo htmlspecialchars($member['nom']); ?></h5>
                            <p><?php echo htmlspecialchars($member['metier']); ?></p>
                        </div>
                    </div>
                    <div class="au-message__item-time">
                        <span><?php echo htmlspecialchars($member['email']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-lg-5">
        <!-- Right Section -->
        <div id="formContainer" class="d-none border p-4 rounded shadow-sm">
        <form action="AddMembre.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Entrez votre nom" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Entrez votre email" required>
    </div>
    <div class="mb-3">
        <label for="metier" class="form-label">Métier</label>
        <input type="text" id="metier" name="metier" class="form-control" placeholder="Entrez votre métier" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" id="image" name="image" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
</form>

        </div>
    </div>
</div>


                        </div>


            <!-- here ADMIN-->


                        <div class="row">
    <div class="col-lg-7">
        <!-- Left Section -->
        <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
            <div class="au-card-title" style="background-image:url('images/bg-title-02.jpg');">
                <div class="bg-overlay bg-overlay--blue"></div>
                <h3>
                    <i class="zmdi zmdi-comment-text"></i>Admins
                </h3>
                <button id="toggleFormButton" class="au-btn-plus">
                    <i class=""></i>
                </button>
            </div>

            <div class="au-inbox-wrap js-inbox-wrap">
                <div class="au-message js-list-load">
                    <div class="au-message__noti">
                        <p>There are
                            <span><?php echo htmlspecialchars($totalAdmins, ENT_QUOTES, 'UTF-8'); ?></span>
                            Admins
                        </p>
                    </div>
                </div>
            </div>

            <!-- Members List -->
            <?php foreach ($admins as $index => $admin): ?>
            <div class="au-message__item unread">
                <div class="au-message__item-inner">
                    <div class="au-message__item-text">
                        <div class="avatar-wrap">
                            <div class="avatar">
                                <img src="<?php echo htmlspecialchars($admin['image']); ?>" alt="John Smith">
                            </div>
                        </div>
                        <div class="text">
                            <h5 class="name"><?php echo htmlspecialchars($admin['nom']); ?></h5>
                            <p>Admin</p>
                        </div>
                    </div>
                    <div class="au-message__item-time">
                        <span><?php echo htmlspecialchars($admin['email']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- <div class="col-lg-5">
    <div id="formContainer" class="d-none border p-4 rounded shadow-sm">
        <form action="AddAdmin.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le nom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Entrez l'email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Entrez le mot de passe" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image (optionnelle)</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter Admin</button>
        </form>
    </div>
</div> -->

    <div class="col-lg-5">
       
        <div id="formContainer" class="d-none border p-4 rounded shadow-sm">
        <form action="AddMembre.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Entrez votre nom" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Entrez votre email" required>
    </div>
    <div class="mb-3">
        <label for="metier" class="form-label">Métier</label>
        <input type="text" id="metier" name="metier" class="form-control" placeholder="Entrez votre métier" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" id="image" name="image" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
</form>

        </div>
    </div>
</div>


                        </div>






                        <div class="au-chat">


                        </div>
                    </div>
                </div>

            </div>
            <!-- <div class="col-4"></div> -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="copyright">
                    <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- END MAIN CONTENT-->
     
     
       <!-- jQuery JS -->
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
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
    
    <!-- Custom Scripts -->
    <script>
        // Row Filtering
        document.getElementById('datatable-selector').addEventListener('change', function() {
            const rowsPerPage = parseInt(this.value);
            const table = document.getElementById('players-table');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach((row, index) => {
                row.style.display = (index < rowsPerPage) ? '' : 'none';
            });
        });

        // Table Search
        document.getElementById('datatable-input').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const table = document.getElementById('players-table');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const text = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // Toggle Form Visibility
        const toggleButton = document.getElementById('toggleFormButton');
        const formContainer = document.getElementById('formContainer');

        if (toggleButton && formContainer) {
            toggleButton.addEventListener('click', () => {
                formContainer.classList.toggle('d-none');
            });
        }

        // Dropdown Menu
        $(document).ready(function() {
            $('.js-item-menu').on('click', function(e) {
                // e.preventDefault();
                $(this).toggleClass('show-dropdown');
                var dropdown = $(this).find('.js-dropdown');
                dropdown.toggleClass('show');
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.js-item-menu').length) {
                    $('.js-item-menu').removeClass('show-dropdown');
                    $('.js-dropdown').removeClass('show');
                }
            });
        });
    </script>
    

    <!-- Main JS -->
    <script src="js/main.js"></script>
</body>
</html>