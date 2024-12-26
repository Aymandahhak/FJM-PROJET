<?php
// Inclure la connexion à la base de données
require_once 'connecter.php';

// Démarrer la session
session_start();

// Initialiser la variable $coachInfo
$coachInfo = null;

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    $coachId = $_SESSION['user_id'];

    // Fonction pour récupérer les informations du coach
    function getCoachInfo($pdo, $coachId) {
        $stmt = $pdo->prepare("SELECT * FROM entraineur WHERE id = ?");
        $stmt->execute([$coachId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les informations du coach
    $coachInfo = getCoachInfo($pdo, $coachId);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Gestion de joueurs</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
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
	<link rel="stylesheet" href="assets/css/css.css">
	<link rel="stylesheet" href="assets/css/dropmenu.css">

	<style>
		.main-menu ul li.active a {
			color:  #2596c5; 
			font-weight: bold;
		}
		
	
	</style>

</head>
<body>


	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">
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
                            <?php
                            // Define the current page
                            $current_page = basename($_SERVER['PHP_SELF']);
                            ?>
                            <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                                <a href="index.php">Home</a>
                            </li>
                            <li class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">
                                <a href="about.php">About</a>
                            </li>
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="<?php echo ($current_page == 'entraineur.php') ? 'active' : ''; ?>">
                                <a href="entraineur.php">Profile</a>
                            </li>
                            <?php endif; ?>
                            
                            <li class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
                                <a href="contact.php">Contact</a>
                            </li>
                            <?php if (isset($_SESSION['user_id'])): ?>
							<li class="user-dropdown">
								<a href="#" class="user-dropdown-toggle">
									<?php echo htmlspecialchars($coachInfo['nom']); ?>
									<span class="dropdown-arrow"></span>
								</a>
								<div class="user-dropdown-menu">
									<div class="dropdown-header">My Account</div>
									<a href="entraineur.php">
										<i class="bi bi-person-circle"></i>Profile
									</a>
									<div class="dropdown-divider"></div>
									<a href="logout.php">
										<i class="bi bi-box-arrow-right"></i>Log Out
									</a>
								</div>
							</li>
							<?php else: ?>
							<li>
								<div class="header-icons">
									<a href="connexion.php" class="boxed-">Log In</a>
								</div>
							</li>
							<?php endif; ?>
                        </ul>
                    </nav>
                    <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                    <div class="mobile-menu"></div>
                    <!-- menu end -->
                </div>
            </div>
        </div>
    </div>
</div>


	<!-- end header -->
	
	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<div class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<input type="text" placeholder="Keywords">
							<button type="submit">Search <i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end search area -->

	<!-- hero area -->
	<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							<p class="subtitle" >Match & Entrainement</p>
							<h1>GET YOUR FUTURE</h1>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->
<br><br>
<img src="assets/img/sec.png" alt="">
	<br>
	<br><br>
	
	<section class="hero-section">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-md-4">
					<img src="assets/img/frmf.png" alt="Logo FRMF" class="img-fluid">
				</div>
				<div class="col-md-4">
					<h1>Partenariat FRMF & OCP</h1>
					<p style="color: aliceblue;">Un partenariat stratégique pour l'avenir du football et du développement durable.</p>
				</div>
				<div class="col-md-4">
					<img src="assets/img/ocp.png" alt="Logo OCP" class="img-fluid">
				</div>
			</div>
		</div>
	</section>
	
	
	
	<!-- cart banner section -->
	<section class="cart-banner pt-100 pb-100">
    	<div class="container">
        	<div class="row clearfix">
            	<!--Image Column-->
            	<div class="image-column col-lg-6">
                	<div class="image">
                    	
                    	<img src="assets/img/partenaria.jpeg" alt="">
                    </div>
                </div>
				
                <!--Content Column-->
                <div class="content-column col-lg-6">

					<h3>Un Partenariat Historique <br> entre la  <span class="orange-text">FRMF</span> et <span class="orange-text">l'OCP</span></h3>
                    <br>
					<h4>Fouzi Lekjaa  &  Mostafa Terrab</h4>
				
                    <div class="text">La Fédération Royale Marocaine de Football (FRMF), 
						présidée par Faouzi Lekjaa, et le Groupe OCP, leader mondial dans 
						l'industrie des phosphates, ont signé un partenariat stratégique visant à renforcer
						 le développement du football marocain. Cet accord porte sur l'amélioration
						 	  des infrastructures sportives, le soutien des jeunes talents et l'organisation d'événements d'envergure internationale pour promouvoir la présence du Maroc sur la scène mondiale.</div>
        
                </div>
            </div>
        </div>
    </section>
    <!-- end cart banner section -->

	<!-- testimonail-section -->
	
	</div>
	<!-- end testimonail-section -->
	

	
	 <br>
	 <br>
	
	<!-- latest news -->
	<div class="latest-news pt-150 pb-150">
		<div class="container">

			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">About</span> Us</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="single-latest-news">
						<a href="single-news.php"><div class="latest-news-bg news-bg-1"></div></a>
						<div class="news-text-box">
							<h3><a href="single-news.php">Lorem You will vainly look for fruit on it in autumn.</a></h3>
							<p class="blog-meta">
								<span class="author"><i class="fas fa-user"></i> Admin</span>
								<span class="date"><i class="fas fa-calendar"></i> 27 December, 2019</span>
							</p>
							<p class="excerpt">Lorem Vivamus lacus enim, pulvinar vel nulla sed, scelerisque rhoncus nisi. Praesent vitae mattis nunc, egestas viverra eros.</p>
							<a href="article1.php" class="read-more-btn">read more <i class="fas fa-angle-right"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="single-latest-news">
						<a href="single-news.php"><div class="latest-news-bg news-bg-2"></div></a>
						<div class="news-text-box">
							<h3><a href="single-news.php">Lorem A man's worth has its season, like tomato.</a></h3>
							<p class="blog-meta">
								<span class="author"><i class="fas fa-user"></i> Admin</span>
								<span class="date"><i class="fas fa-calendar"></i> 27 December, 2019</span>
							</p>
							<p class="excerpt">Lorem Vivamus lacus enim, pulvinar vel nulla sed, scelerisque rhoncus nisi. Praesent vitae mattis nunc, egestas viverra eros.</p>
							<a href="article2.php" class="read-more-btn">read more <i class="fas fa-angle-right"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
					<div class="single-latest-news">
						<a href="single-news.php"><div class="latest-news-bg news-bg-3">
						</div></a>
						<div class="news-text-box">
							<h3><a href="single-news.php">Lorem Good thoughts bear good fresh juicy fruit.</a></h3>
							<p class="blog-meta">
								<span class="author"><i class="fas fa-user"></i> Admin</span>
								<span class="date"><i class="fas fa-calendar"></i> 27 December, 2019</span>
							</p>
							<p class="excerpt">Lorem Vivamus lacus enim, pulvinar vel nulla sed, scelerisque rhoncus nisi. Praesent vitae mattis nunc, egestas viverra eros.</p>
							<a href="article3.php" class="read-more-btn">read more <i class="fas fa-angle-right"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 text-center">
					<a href="news.php" class="boxed-btn">More News</a>
				</div>
			</div>
		</div>
	</div>
	<!-- end latest news -->



	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-box about-widget">
						<h2 class="widget-title">Lorem About us</h2>
						<p>Lorem Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae.</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title">Get in Touch</h2>
						<ul>
							<li>34/8,aymane,  oussama, aymane, azzdine</li>
							<li>contact@getyourfuture.com</li>
							<li>+212 6 11 22 33 44</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box pages">
						<h2 class="widget-title">Pages</h2>
						<ul>
							<li><a href="index.php">Home</a></li>
							<li><a href="about.php">About</a></li>
							<li><a href="entraineur.php">Profile</a></li>
							<li><a href="contact.php">Contact</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box subscribe">
						<h2 class="widget-title">Subscribe</h2>
						<p>Subscribe to our mailing list to get the latest updates.</p>
						<form action="index.php">
							<input type="email" placeholder="Email">
							<button type="submit"><i class="fas fa-paper-plane"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	
	<!-- jquery -->
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