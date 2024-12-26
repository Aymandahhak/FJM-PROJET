<?php
session_start();
include('connecter.php'); // Include the database connection file

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    $userName = $_SESSION['user']; // Retrieve the user's name from the session
   
    // Fetch the role from the database
    $stmt = $pdo->prepare("SELECT role FROM entraineur WHERE nom = :userName");
    $stmt->execute(['userName' => $userName]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $stmt = $pdo->prepare("SELECT role FROM joueurs WHERE nom = :userName");
        $stmt->execute(['userName' => $userName]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if (!$user) {
        $stmt = $pdo->prepare("SELECT role FROM admins WHERE nom = :userName");
        $stmt->execute(['userName' => $userName]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if ($user) {
        $_SESSION['role'] = $user['role']; // Store the role in the session
    } else {
        $_SESSION['role'] = null; // If no role found, set it to null
    }
} else {
    $userName = null; // If not logged in, userName will be null
    $_SESSION['role'] = null; // If not logged in, role will be null
} 

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Home</title>

	<!-- favicon -->
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
	<link rel="stylesheet" href="assets/css/mainHome.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">
<style>
  /* Style for the user info container */
.user-info {
    font-size: 16px; /* Adjust text size */
    color: white; /* Text color */
    font-weight: bold;
    display: flex; /* Align items horizontally */
    align-items: center;
    gap: 5px; /* Spacing between elements */
}

/* Styling for the logout link */
.user-info .logout-btn {
    color: #d9534f; /* Red color for logout */
    text-decoration: none; /* Remove underline */
    font-weight: normal; /* Differentiate from username */
    padding: 5px 10px; /* Add padding for better click area */
    border: 1px solid #d9534f; /* Add border to match the color */
    border-radius: 4px; /* Rounded edges */
    transition: background-color 0.3s, color 0.3s; /* Smooth hover effect */
}

/* Hover effect for logout button */
.user-info .logout-btn:hover {
    background-color: #d9534f; /* Red background */
    color: #fff; /* White text */
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
                                                <?php echo htmlspecialchars($_SESSION['user']); ?>
                                                <a href="index.php?logout=true" class="boxed-btn">Logout</a>
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
	<!-- end header -->
	<!-- hero area -->
	<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							<p class="subtitle" >Match & Entrainement</p>
							<h1>Get Your Future </h1>
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->
<br>

	 <style>
    /* Background section */
    .section-inscription {
      background-color: #ffffff; /* Couleur blanche */
      color: #333; /* Texte sombre pour contraste */
      text-align: center;
      padding: 100px 15px;
      position: relative;
      overflow: hidden;
    }

    /* Animated text */
    .inscription-heading {
      font-size: 3rem;
      font-weight: bold;
      animation: slideInInscription 1.5s ease-out forwards;
      opacity: 0;
    }

    .inscription-subheading {
      font-size: 1.5rem;
      margin-top: 15px;
      animation: fadeInInscription 2s ease-out forwards;
      opacity: 0;
    }

    @keyframes slideInInscription {
      0% {
        transform: translateY(-50px);
        opacity: 0;
      }

      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes fadeInInscription {
      0% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    /* Animated button */
    .btn-inscription {
      position: relative;
      overflow: hidden;
      color: white;
      background-color: #007bff;
      border: none;
      padding: 15px 30px;
      font-size: 1.2rem;
      font-weight: bold;
      border-radius: 50px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-inscription:hover {
      transform: scale(1.1);
      box-shadow: 0px 10px 30px rgba(0, 123, 255, 0.5);
    }

    .btn-inscription::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .btn-inscription:hover::after {
      opacity: 1;
    }

    /* Scroll reveal effect */
    .scroll-reveal-inscription {
      opacity: 0;
      transform: translateY(50px);
      transition: all 0.6s ease-in-out;
    }

    .scroll-reveal-inscription.revealed {
      opacity: 1;
      transform: translateY(0);
    }

    /* Responsive text */
    @media (max-width: 768px) {
      .inscription-heading {
        font-size: 2.5rem;
      }

      .inscription-subheading {
        font-size: 1.2rem;
      }

      .btn-inscription {
        font-size: 1rem;
        padding: 10px 20px;
      }
    }
  </style>
</head>

<body>
  <!-- Section d'inscription -->
  <section class="section-inscription">
    <div class="container">
      <!-- Animated heading -->
      <h1 class="inscription-heading scroll-reveal-inscription">
        🎉 Registrations are open for the year <span style="color: #007bff;">2025</span> !
      </h1>
      <!-- Animated subheading -->
      <p class="inscription-subheading scroll-reveal-inscription">
       Join us now and start your journey for a bright future.
      </p>
      <!-- Animated button -->
      <div class="mt-4 scroll-reveal-inscription">
        <a href="article1.php" class="btn btn-inscription">Start Pre-registration</a>
      </div>
    </div>
  </section>

  <!-- JavaScript pour activer l'effet de scroll -->
  <script>
    // Fonction pour révéler les éléments lors du défilement
    const revealElements = document.querySelectorAll('.scroll-reveal-inscription');

    const revealOnScroll = () => {
      const viewportHeight = window.innerHeight;

      revealElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;

        if (elementTop < viewportHeight - 100) {
          element.classList.add('revealed');
        }
      });
    };

    // Activer la fonction au défilement
    window.addEventListener('scroll', revealOnScroll);

    // Exécuter une fois au chargement pour les éléments déjà visibles
    revealOnScroll();
  </script>

<br>
<br>
<style>
    /* Reset and Basic Styles */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    #container {
      display: flex;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }

    .section {
      flex: 1; /* Each section takes equal space by default */
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 2rem;
      font-weight: bold;
      background-size: cover;
      background-position: center;
      transition: flex 0.5s ease, transform 0.5s ease;
    }

    /* Define backgrounds for each section */
    #section-1 {
      background-image: url(assets/img/slider/image2.jpg); /* Replace with your images */
    }

    #section-2 {
      background-image: url(assets/img/slider/image3.jpg);
    }

    #section-3 {
      background-image: url(assets/img/slider/image4.jpg);
    }

    #section-4 {
      background-image: url(assets/img/slider/image1.jpg);
    }

    /* Hover Effect */
    .section:hover {
      flex: 3; /* Enlarges the hovered section */
      transform: scale(1.05); /* Adds a slight zoom effect */
    }

    #container .section:not(:hover) {
      flex: 1; /* Shrinks the non-hovered sections */
      transform: scale(0.95); /* Slight shrink for contrast */
    }

    /* Text and Number Styles */
    .number {
      position: absolute;
      top: 10%;
      left: 10%;
      font-size: 3rem;
      z-index: 2;
      color: white;
      text-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
    }

    .text {
      position: absolute;
      bottom: 10%;
      left: 10%;
      font-size: 2rem;
      z-index: 2;
      color: white;
      text-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
    }

    /* Prevent text overflow issues */
    .section * {
      pointer-events: none;
    }
  </style>
</head>
<body>
  <!-- Structure HTML -->
  <div id="container">
    <div class="section" id="section-1">
      <div class="number">01</div>
	  <div class="text">Technical Program</div>
    </div>
    <div class="section" id="section-2">
      <div class="number">02</div>
	  <div class="text">Academic Program</div>
    </div>
    <div class="section" id="section-3">
      <div class="number">03</div>
	  <div class="text">Goalkeeper program</div>
    </div>
    <div class="section" id="section-4">
      <div class="number">04</div>
	  <div class="text">International Programs</div>
	
    </div>
  </div>
<br>
<section id="About">
	<!-- latest news -->
	<div class="latest-news pt-150 pb-150" >
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
						<a href="article1.php"><div class="latest-news-bg news-bg-1"></div></a>
						<div class="news-text-box">
							<h3><a href="single-news.php">Registration Documents</a></h3>
							
							<p class="excerpt">
              This training is intended only for children aged 7 to 18 years old. Make sure that the age of the participant falls within this range before registration.</p>
							<a href="article1.php" class="boxed-btn">read more</a>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="single-latest-news">
						<a href="article2.php"><div class="latest-news-bg news-bg-2"></div></a>
						<div class="news-text-box">
							<h3><a href="single-news.php">Football Training Tips</a></h3>
							
							<p class="excerpt">A football training session is usually divided into three parts: the warm-up prepares players physically and mentally for the session,</p>
							<a href="article2.php" class="boxed-btn">read more </a>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
					<div class="single-latest-news">
						<a href="article3.php"><div class="latest-news-bg news-bg-3">
						</div></a>
						<div class="news-text-box">
							<h3><a href="single-news.php">FRMF & OCP Partnership</a></h3>
							<p class="excerpt">The Royal Moroccan Football Federation (FRMF), chaired by Faouzi Lekjaa, and the OCP Group, world leader in the phosphate industry, have signed a ....</p>
							<a href="article3.php" class="boxed-btn" >read more </a>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	</section>
	<!-- end latest news -->
<br>

  <!-- Script JavaScript intégré -->
  <script>
    // Ajoute une animation de zoom lorsqu'on survole une section
    const sections = document.querySelectorAll('.section');

    sections.forEach((section) => {
      section.addEventListener('mouseover', () => {
        section.style.transform = 'scale(1.1)';
      });

      section.addEventListener('mouseout', () => {
        section.style.transform = 'scale(1)';
      });
    });
  </script>
<!-- featured section -->
<div class="section-title">    
    <h3><span class="orange-text">Method</span>ology</h3>
	<p>At Get Your Future, we believe in a holistic approach to development. Our methodology focuses on enhancing personal, mental, and technical skills to help individuals achieve excellence both on and off the field. Whether you're looking to build mental toughness, improve technical proficiency, or master the strategic aspects of the game, our program offers comprehensive training designed to unlock your full potential.</p>

	</div>

<div class="feature-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="featured-text">
                        <h2 class="pb-3">GET YOUR FUTURE <span class="orange-text">Methodology</span></h2>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 mb-4 mb-md-5">
                                <div class="list-box d-flex">
                                    <div class="content">
                                        <h3>Personal Development</h3>
                                        <p>More than a sport, a path to personal excellence. Let's cultivate personal development.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-5 mb-md-5">
                                <div class="list-box d-flex">
                                    <div class="content">
                                        <h3>Mental Development</h3>
                                        <p>Elevate the game, enrich the mind. Mental development is at the heart of Get Your Future.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-5 mb-md-5">
                                <div class="list-box d-flex">
                                    <div class="content">
                                        <h3>Technical Skills</h3>
                                        <p>Sharpen your talents, master the art. Technical excellence at Get Your Future.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="list-box d-flex">
                                    <div class="content">
                                        <h3>Tactical Skills</h3>
                                        <p>Strategy, precision, victory: Perfect your tactical skills at Get Your Future.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end featured section -->
<br>
  <style>
    

    .section-title {
      text-align: center;
      font-weight: bold;
      font-size: 2.5rem;
      color: #2596c5; /* Juventus Gold */
      margin-bottom: 40px;
    }

    .coach-card {
      background: #fff;
      border: 1px solid #333;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .coach-card img {
      width: 100%;
      height: 350px;
      object-fit: cover;
    }

    .coach-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.6);
    }

    .card-body {
      padding: 20px;
    }

    .coach-name {
      font-size: 1.25rem;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .coach-role {
      font-size: 1rem;
      color: #2596c5;
    }

    .profile-btn {
      margin-top: 15px;
      background-color: #2596c5; /* Juventus Gold */
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 40px;
      padding: 10px 20px;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .profile-btn:hover {
      background-color: #162133;
      transform: scale(1.05);
    }

    @media (max-width: 768px) {
      .coach-card img {
        height: 200px;
      }
    }
  </style>


  <!-- Header Section -->
  <div class="container py-5">
    <h1 class="section-title">OUR <span style="color: #000;">TEAM</span></h1>
    
    <!-- Coaches Section -->
    <div class="row g-4">
      <!-- Coach 1 -->
      <div class="col-lg-4 col-md-6">
        <div class="coach-card">
          <img src="assets/img/entreneur/E1.jpg" alt="Coach 1">
          <div class="card-body text-center">
			<h5 class="coach-name">ABDALLAH IDRISSI</h5>
			<p class="coach-role">Football Coach</p>
      <a href="coach_view1.html" class="profile-btn">View Profile</a>
          </div>
        </div>
      </div>

      <!-- Coach 2 -->
      <div class="col-lg-4 col-md-6">
        <div class="coach-card">
          <img src="assets/img/entreneur/E2.jpg" alt="Coach 2">
          <div class="card-body text-center">
		  <h5 class="coach-name">NOUREDDINE BOUBOU</h5>
			<p class="coach-role">Football Coach</p>
      <a href="coach_view2.html" class="profile-btn">View Profile</a>
          </div>
        </div>
      </div>

      <!-- Coach 3 -->
      <div class="col-lg-4 col-md-6">
        <div class="coach-card">
          <img src="assets/img/entreneur/E3.jpg" alt="Coach 3">
          <div class="card-body text-center">
		    <h5 class="coach-name">ABDALLAH IDRISSI</h5>
			<p class="coach-role">Football Coach</p>
			<a href="coach_view3.html" class="profile-btn">View Profile</a>

          </div>
        </div>
      </div>
    </div>
  </div>

  
	 <br>


	

	
<br>
<div class="footer-area">
    <div class="container">
        <div class="row">
            <!-- About Us Section -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-box about-widget">
                    <h2 class="widget-title">About Us</h2>
                    <p>We are committed to providing exceptional service and delivering quality results. Our team is dedicated to ensuring customer satisfaction and success in all projects we undertake.</p>
                </div>
            </div>
            
            <!-- Contact Information Section -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-box get-in-touch">
                    <h2 class="widget-title">Get in Touch</h2>
                    <ul>
                        <li>34/8, Aymane Street, Oussama, Aymane, Azzdine</li>
                        <li>contact@getyourfuture.com</li>
                        <li>+212 6 11 22 33 44</li>
                    </ul>
                </div>
            </div>
            
            <!-- Quick Links Section -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-box pages">
                    <h2 class="widget-title">Pages</h2>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Newsletter Subscription Section -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-box subscribe">
                    <h2 class="widget-title">Subscribe</h2>
                    <p>Stay updated with our latest news and offers. Subscribe to our newsletter.</p>
                    <form action="index.php">
                        <input type="email" placeholder="Enter your email" required>
                        <button type="submit"><i class="fas fa-paper-plane"></i> Subscribe</button>
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