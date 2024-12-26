<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'joueur_inscription'; // Remplacez par le nom de votre base
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    $token = htmlspecialchars(trim($_POST['token']));

    // Validation de base
    if (empty($name) || empty($email) || empty($message) || empty($token)) {
        $error = "Tous les champs obligatoires (*) doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "L'adresse e-mail n'est pas valide.";
    } else {
        // Préparer et exécuter la requête SQL
        try {
            $sql = "INSERT INTO contact_form (name, email, phone, subject, message, token) 
                    VALUES (:name, :email, :phone, :subject, :message, :token)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':subject' => $subject,
                ':message' => $message,
                ':token' => $token
            ]);

            $success = "Message envoyé avec succès ! Nous vous répondrons sous peu.";
        } catch (PDOException $e) {
            $error = "Une erreur s'est produite lors de l'envoi du message : " . $e->getMessage();
        }
    }
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
	<title>contact</title>

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
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">

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
								<li class="current-list-item"><a href="index.php">Home</a>
									</li>
								<li><a href="index.php#About">About</a></li>
								
								<li><a href="contact.php">Contact</a></li>
								
								<li>
								<div class="header-icons">
								<a href="connexion.php" class="boxed-">Connexion</a>
								</div>
								</li>
							</ul>
						</nav>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>GET YOUR FUTURE </p>
						<h1>Contact</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- contact form -->
	<div class="contact-from-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-1 mb-0 mb-lg-0"></div>
				<div class="col-lg-10 mb-5 mb-lg-0">
					<div class="form-title">
					<h2>Do you have any questions?</h2>
<p>If you have any questions or need further assistance, feel free to reach out to us. We're here to help and will get back to you as soon as possible. Let us know how we can assist you!</p>
					</div>
				 	<div id="form_status"></div>
					<div class="contact-form">
					<form type="POST" id="fruitkha-contact" onSubmit='contact.php'>
    <p>
        <input type="text" placeholder="Name" name="name" id="name">
        <input type="email" placeholder="Email" name="email" id="email">
    </p>
    <p>
        <input type="tel" placeholder="Phone" name="phone" id="phone">
        <input type="text" placeholder="Subject" name="subject" id="subject">
    </p>
    <p>
        <textarea name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea>
    </p>
    <input type="hidden" name="token" value="FsWga4&@f6aw" />
    <p>
        <input type="submit" value="Submit">
    </p>
</form>

					</div>
				</div>
				
				</div>
				<div class="col-lg-1 mb-0 mb-lg-0"></div>
			</div>
		</div>
	</div>
	<!-- end contact form -->

	


	<!-- footer -->
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
	<!-- form validation js -->
	<script src="assets/js/form-validate.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>
	
</body>
</html>