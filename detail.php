<?php
require_once 'connecter.php';
require_once 'joueurs.php';

session_start();
// Au début du fichier, après session_start()
$player_id = null;

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id'])) {
    $player_id = intval($_GET['id']);
} else {
    // Rediriger si pas d'ID
    header('Location: suiviejoueurs.php');
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projetg";

try {
    // Créer la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Préparer la requête pour récupérer les informations du joueur
    $stmt = $conn->prepare("SELECT * FROM joueurs WHERE id = ?");
    $stmt->bind_param("i", $player_id);
    $stmt->execute();
    $player_result = $stmt->get_result();

    if ($player_result->num_rows === 0) {
        // Si aucun joueur n'est trouvé avec cet ID
        header('Location: suiviejoueurs.php');
        exit();
    }

    // Récupérer les données du joueur
    $row = $player_result->fetch_assoc();
    $name = htmlspecialchars($row['nom']);
    $image_path = htmlspecialchars($row['image_path']);
    $age = htmlspecialchars($row['age']);
    $position = htmlspecialchars($row['position']);
    $height = htmlspecialchars($row['height']);
    $weight = htmlspecialchars($row['weight']);
    $hometown = htmlspecialchars($row['hometown']);
    $dream = htmlspecialchars($row['dream']);

    // Ensuite, récupérer les autres informations (schedule, achievements, etc.)
    // en utilisant le même $player_id
    // ...

} catch (Exception $e) {
    error_log($e->getMessage());
    die("Une erreur est survenue. Veuillez réessayer plus tard.");
}

// Fetch player information
 // Example player ID

// Prepare and bind for player info
$stmt = $conn->prepare("SELECT * FROM joueurs WHERE id = ?");
$stmt->bind_param("i", $player_id);
$stmt->execute();
$player_result = $stmt->get_result();

// Fetch schedule for the player (Placed here)
$schedule_stmt = $conn->prepare("SELECT * FROM schedule WHERE player_id = ?");
$schedule_stmt->bind_param("i", $player_id);
$schedule_stmt->execute();
$schedule_result = $schedule_stmt->get_result();

// Fetch achievements for player
$achievement_stmt = $conn->prepare("SELECT * FROM achievement WHERE player_id = ?");
$achievement_stmt->bind_param("i", $player_id);
$achievement_stmt->execute();
$achievement_result = $achievement_stmt->get_result();

// Fetch medical status for player
$medical_stmt = $conn->prepare("SELECT * FROM medical_status WHERE player_id = ?");
$medical_stmt->bind_param("i", $player_id);
$medical_stmt->execute();
$medical_result = $medical_stmt->get_result();

// Fetch trainers from the 'entraineur' table
$trainer_stmt = $conn->prepare("SELECT * FROM entraineur");
$trainer_stmt->execute();
$trainer_result = $trainer_stmt->get_result();

// Initialize arrays for data
$trainers = [];
$achievements = [];
$schedule = [];

if ($player_result->num_rows > 0) {
  // Output data of the player row
  $row = $player_result->fetch_assoc();
  $name = htmlspecialchars($row['nom']);
  $image_path = htmlspecialchars($row['image_path']);
  $age = htmlspecialchars($row['age']);
  $position = htmlspecialchars($row['position']);
 // Add this line
  $height = htmlspecialchars($row['height']);
  $weight = htmlspecialchars($row['weight']);
  $hometown = htmlspecialchars($row['hometown']);
  $dream = htmlspecialchars($row['dream']);

  // Validate and set image path for player
  $image_path = !empty($image_path) && file_exists("assets3/img/player/" . basename($image_path))
    ? "assets3/img/player/" . basename($image_path)
    : "assets3/img/player/default-player.jpg";
} else {
  // Default values if no player found
  $name = "Player";
  $image_path = "assets3/img/player/default-player.jpg";
  $age = "N/A";
  $position = "N/A";
  $height = "N/A";
  $weight = "N/A";
  $hometown = "N/A";
  $dream = "No dream found.";
}

if ($achievement_result->num_rows > 0) {
  // Fetch all achievements for the player
  while ($achievement_row = $achievement_result->fetch_assoc()) {
    $achievements[] = [
      'title' => htmlspecialchars($achievement_row['title']),
      'description' => htmlspecialchars($achievement_row['description']),
      'date' => htmlspecialchars($achievement_row['achievement_date']),
      'image' => htmlspecialchars($achievement_row['achievement_image']),
      'category' => 'General', // Default category
    ];
  }
} else {
  // Default if no achievements are found
  $achievements[] = [
    'title' => 'No achievements available',
    'description' => '',
    'date' => '',
    'image' => 'assets3/img/player achivemennts/default-achievement.jpg',
  ];
}

// Handle medical status
if ($medical_result->num_rows > 0) {
  $medical_status = $medical_result->fetch_assoc();
  $conditionP = htmlspecialchars($medical_status['conditionP']);
  $injury_history = htmlspecialchars($medical_status['injury_history']);
  $fitness_level = htmlspecialchars($medical_status['fitness_level']);
  $last_checkup_date = htmlspecialchars($medical_status['last_checkup_date']);
  $notes = htmlspecialchars($medical_status['notes']);
  $cleared_to_play = $medical_status['cleared_to_play'] ? "Yes" : "No";
} else {
  // Default values if no medical status found
  $conditionP = "Unknown";
  $injury_history = "No data available.";
  $fitness_level = "Unknown";
  $last_checkup_date = "N/A";
  $notes = "No notes.";
  $cleared_to_play = "No";
}

// Fetch trainers data and store in array
if ($trainer_result->num_rows > 0) {
  while ($trainer_row = $trainer_result->fetch_assoc()) {
    $trainers[] = [
      'name' => htmlspecialchars($trainer_row['nom']),
      'age' => htmlspecialchars($trainer_row['age']),
      'nationality' => htmlspecialchars($trainer_row['nationalite']),
      'email' => htmlspecialchars($trainer_row['email']),
      'photo' => !empty($trainer_row['photo']) && file_exists("assets/img/entreneur/" . basename($trainer_row['photo']))
        ? "assets/img/entreneur/" . basename($trainer_row['photo'])
        : "assets/img/entreneur/default-trainer.jpg",
      'poste' => htmlspecialchars($trainer_row['poste']),
    ];
  }
} else {
  // Default if no trainers found
  $trainers[] = [
    'name' => 'No trainers available',
    'age' => 'N/A',
    'nationality' => 'N/A',
    'email' => 'N/A',
    'photo' => 'assets3/img/default-trainer.jpg',
    'poste' => 'N/A',
  ];
}

// Define academy contact information
$academy_address = "123 Football St, Marrakech, Morocco";
$academy_phone = "+1 5589 55488 55";
$academy_email = "info@frmf.com";

// Fetch schedule data and store in array
if ($schedule_result->num_rows > 0) {
  while ($schedule_row = $schedule_result->fetch_assoc()) {
    $schedule[] = [
      'title' => htmlspecialchars($schedule_row['title']),
      'description' => htmlspecialchars($schedule_row['description']),
      'date' => htmlspecialchars($schedule_row['date']),
      'time' => htmlspecialchars($schedule_row['time']),
      'location' => htmlspecialchars($schedule_row['location']),
      'activity_type' => htmlspecialchars($schedule_row['activity_type']),
    ];
  }
} else {
  // Default if no schedule found
  $schedule[] = [
    'title' => 'No schedule available',
    'description' => '',
    'date' => '',
    'time' => '',
    'location' => '',
    'activity_type' => 'N/A',
  ];
}

// Close statements
$stmt->close();
$achievement_stmt->close();
$medical_stmt->close();
$trainer_stmt->close();
$schedule_stmt->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>PROFILE</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets3/img/R (1).png" rel="icon">
  <link href="assets3/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets3/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets3/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets3/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets3/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets3/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets3/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-lg-0">
        <img src="assets3/img/R (1).png" alt="" href="https://frmf.ma/">
        <h1 class="sitename">FJM</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#aceuil" class="active">Home<br></a></li>
          <li><a href="#hero">PROFILE</a></li>
          <li><a href="#about">about</a></li>
          <li><a href="#features">achievements</a></li>
          <li><a href="#medical-status">suivi medical</a></li>
        
          <li><a href="#emploi">l'emploi</a></li>
          <li><a href="#contact">CONTACT</a></li>

        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      
      <a class="btn-getstarted" href="suiviejoueurs.php" style="margin-right: 10px;">
  <i class="bi bi-arrow-left"></i> Retour
</a>
      <a class="btn-getstarted" href="index.php">déconnection</a>

    </div><!-- End Features Item-->
  </header>

  <main class="main">

    <!-- filepath: /c:/xampp/htdocs/profilee joueur/profile joueur.php -->
    <!-- Hero Section -->
    <section id="hero" class="hero-section">
      <div class="hero-bg">
        <img src="assets3/img/jm.jpg" alt="Background" class="parallax-bg">
        <div class="overlay"></div>
      </div>

      <div class="container">
        <div class="hero-content" data-aos="fade-up">
          <div class="player-welcome">
            <h1 class="glowing-title">Welcome <span class="highlight"><?php echo $name; ?></span></h1>
            <p class="subtitle">Centre de Formation de Football Marocain</p>
          </div>

          <div class="quick-actions">
            <div class="action-card" data-aos="fade-up" data-aos-delay="100">
              <div class="card-icon">
                <i class="bi bi-person-badge"></i>
              </div>
              <h3>Profile</h3>
              <a href="#about" class="card-link">View Details</a>
            </div>

            <div class="action-card" data-aos="fade-up" data-aos-delay="200">
              <div class="card-icon">
                <i class="bi bi-calendar-check"></i>
              </div>
              <h3>Schedule</h3>
              <a href="#emploi" class="card-link">View Schedule</a>
            </div>

            <div class="action-card" data-aos="fade-up" data-aos-delay="300">
              <div class="card-icon">
                <i class="bi bi-heart-pulse"></i>
              </div>
              <h3>Medical</h3>
              <a href="#medical-status" class="card-link">View Status</a>
            </div>
          </div>
        </div>
      </div>

      <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
      </div>
    </section><!-- /Hero Section -->

    <!-- About Section -->
    <!-- About Section -->
    <section id="about" class="about">
      <div class="container">
        <div class="section-header glowing-text" data-aos="fade-up">
          <h2 class="section-title">Player Profile</h2>
          <p class="section-subtitle">GFJM Football Academy Star</p>
        </div>

        <div class="profile-container">
          <div class="row align-items-center g-4">
            <div class="col-lg-6" data-aos="fade-right">
              <div class="player-image-wrapper">
                <div class="image-frame">
                  <img src="assets3/img/player/<?php echo basename($image_path); ?>" alt="<?php echo htmlspecialchars($name); ?>">
                </div>
                <div class="stats-overlay">
                  <div class="stat-item">
                    <span class="stat-label">Position</span>
                    <span class="stat-value"><?php echo $position; ?></span>
                  </div>
                  <div class="stat-item">
                    <span class="stat-label">Number</span>
                    <span class="stat-value">#</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
              <div class="player-info-card">
                <div class="card-header">
                  <h3 class="player-name"><?php echo $name; ?></h3>
                  <span class="academy-tag"></span>
                </div>

                <div class="info-grid">
                  <div class="info-item">
                    <i class="bi bi-calendar-event"></i>
                    <div class="info-content">
                      <span class="info-label">Age</span>
                      <span class="info-value"><?php echo $age; ?> years</span>
                    </div>
                  </div>

                  <div class="info-item">
                    <i class="bi bi-arrows-fullscreen"></i>
                    <div class="info-content">
                      <span class="info-label">Height</span>
                      <span class="info-value"><?php echo $height; ?> cm</span>
                    </div>
                  </div>

                  <div class="info-item">
                    <i class="bi bi-speedometer2"></i>
                    <div class="info-content">
                      <span class="info-label">Weight</span>
                      <span class="info-value"><?php echo $weight; ?> KG</span>
                    </div>
                  </div>

                  <div class="info-item">
                    <i class="bi bi-geo-alt"></i>
                    <div class="info-content">
                      <span class="info-label">Hometown</span>
                      <span class="info-value"><?php echo $hometown; ?></span>
                    </div>
                  </div>
                </div>

                <div class="player-dream-section">
                  <h4 class="dream-title"><i class="bi bi-stars"></i> Player's Dream</h4>
                  <blockquote class="dream-quote">
                    <p><?php echo $dream; ?></p>
                  </blockquote>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /About Section -->

    <!-- Replace the existing achievement slider code with this -->
    <!-- Achievements Section -->
    <section id="features" class="features section">
      <div class="container">
        <div class="section-header glowing-text" data-aos="fade-up">
          <h2 class="section-title ">Achievements</h2>
          <p class="section-subtitle">My Football Journey</p>
        </div>

        <div class="row achievements-container">
          <div class="col-lg-6" data-aos="fade-right">
            <div class="achievements-showcase">
              <?php if (!empty($achievements)): ?>
                <div class="achievement-slider">
                  <?php foreach ($achievements as $achievement): ?>
                    <div class="achievement-slide">
                      <img src="assets3/img/player achievements/<?php echo htmlspecialchars($achievement['image']); ?>"
                        alt="Achievement Image" class="achievement-image">
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left">
            <div class="achievements-list">
              <?php foreach ($achievements as $index => $achievement): ?>
                <div class="achievement-card" data-aos="zoom-in" data-aos-delay="<?php echo $index * 100; ?>">
                  <div class="achievement-icon">
                    <i class="bi bi-trophy-fill"></i>
                  </div>
                  <div class="achievement-content">
                    <h3><?php echo $achievement['title']; ?></h3>
                    <p><?php echo $achievement['description']; ?></p>
                    <div class="achievement-meta">
                      <span class="date">
                        <i class="bi bi-calendar3"></i>
                        <?php echo $achievement['date']; ?>
                      </span>
                      <span class="category">
                        <i class="bi bi-tag"></i>
                        <?php echo $achievement['category']; ?>
                      </span>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- filepath: /c:/xampp/htdocs/profilee joueur/profile joueur.php -->
    <section id="medical-status" class="medical-status section">
      <div class="container">
        <div class="section-title glowing-text-m" data-aos="fade-up">
          <h2>Medical Status</h2>
          <p>Player Health Overview</p>
        </div>

        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="medical-card " data-aos="fade-up">
              <div class="medical-header">
                <i class="bi bi-heart-pulse"></i>
                <h3>Health Dashboard</h3>
                <span class="status-badge <?php echo $cleared_to_play === 'Yes' ? 'status-active' : 'status-inactive'; ?>">
                  <?php echo $cleared_to_play === 'Yes' ? 'Cleared to Play' : 'Not Cleared'; ?>
                </span>
              </div>

              <div class="medical-grid">
                <div class="medical-item">
                  <i class="bi bi-activity"></i>
                  <h4>Current Condition</h4>
                  <p><?php echo $conditionP; ?></p>
                </div>

                <div class="medical-item">
                  <i class="bi bi-bandaid"></i>
                  <h4>Injury History</h4>
                  <p><?php echo $injury_history; ?></p>
                </div>

                <div class="medical-item">
                  <i class="bi bi-lightning"></i>
                  <h4>Fitness Level</h4>
                  <div class="fitness-meter">
                    <div class="fitness-bar" style="width: <?php echo $fitness_level; ?>%"></div>
                  </div>
                  <p><?php echo $fitness_level; ?>%</p>
                </div>

                <div class="medical-item">
                  <i class="bi bi-calendar-check"></i>
                  <h4>Last Checkup</h4>
                  <p><?php echo $last_checkup_date; ?></p>
                </div>
              </div>

              <div class="medical-notes">
                <h4><i class="bi bi-journal-medical"></i> Medical Notes</h4>
                <p><?php echo $notes; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Team Section -->
   
    <!-- /emploi Section -->
    <!-- Schedule/Emploi Section -->
    <section id="emploi" class="emploi-section section">
      <div class="container">
        <div class="section-title glowing-text-o" data-aos="fade-up">
          <h2>Planning</h2>
          <p>Votre Emploi du Temps</p>
        </div>

        <div class="schedule-container" data-aos="fade-up">
          <?php if (count($schedule) > 0) : ?>
            <div class="schedule-filters">
              <button class="filter-btn active" data-filter="all">All</button>
              <button class="filter-btn" data-filter="training">Training</button>
              <button class="filter-btn" data-filter="match">Match</button>
              <button class="filter-btn" data-filter="fitness">Fitness</button>

            </div>
            <div class="schedule-timeline">
              <div class="schedule-wrapper">
                <?php foreach ($schedule as $session) : ?>
                  <div class="schedule-card" data-category="<?php echo strtolower($session['activity_type']); ?>">
                    <div class="schedule-time">
                      <span class="time"><?php echo $session['time']; ?></span>
                      <span class="date"><?php echo $session['date']; ?></span>
                    </div>

                    <div class="schedule-content">
                      <div class="schedule-header">
                        <h3><?php echo $session['title']; ?></h3>
                        <span class="activity-badge <?php echo strtolower($session['activity_type']); ?>">
                          <?php echo $session['activity_type']; ?>
                        </span>
                      </div>

                      <div class="schedule-details">
                        <p><?php echo $session['description']; ?></p>
                        <div class="schedule-meta">
                          <span><i class="bi bi-geo-alt"></i> <?php echo $session['location']; ?></span>
                          <span class="countdown" data-time="<?php echo $session['time']; ?>" data-date="<?php echo $session['date']; ?>">
                            Starting in: calculating...
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else : ?>
              <div class="no-schedule">
                <i class="bi bi-calendar-x"></i>
                <p>No schedule available for this player.</p>
              </div>
            <?php endif; ?>
            </div>
        </div>
    </section>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Get all filter buttons and schedule cards
        const filterBtns = document.querySelectorAll('.filter-btn');
        const scheduleCards = document.querySelectorAll('.schedule-card');

        // Add click event to each filter button
        filterBtns.forEach(btn => {
          btn.addEventListener('click', () => {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));

            // Add active class to clicked button
            btn.classList.add('active');

            // Get filter value
            const filterValue = btn.getAttribute('data-filter');

            // Filter cards
            scheduleCards.forEach(card => {
              // Get card category
              const cardCategory = card.getAttribute('data-category');

              // Show/hide cards based on filter
              if (filterValue === 'all' || filterValue === cardCategory) {
                card.style.display = 'block';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
              } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                  card.style.display = 'none';
                }, 300);
              }
            });
          });
        });
      });
    </script>
    <!-- /Contact Section -->

    <!-- contact secion Section  -->
    <!-- Contact Section -->
    <section id="contact" class="contact-section section">
      <div class="container">
        <div class="section-title" data-aos="fade-up">
          <h2>Contact</h2>
          <p>Get in Touch</p>
        </div>

        <div class="row gy-4">
          <div class="col-lg-4">
            <div class="contact-info">
              <div class="info-card" data-aos="fade-up" data-aos-delay="100">
                <i class="bi bi-geo-alt pulse-icon"></i>
                <h3>Our Address</h3>
                <p><?php echo $academy_address; ?></p>
              </div>

              <div class="info-card" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-telephone pulse-icon"></i>
                <h3>Call Us</h3>
                <p><?php echo $academy_phone; ?></p>
              </div>

              <div class="info-card" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-envelope pulse-icon"></i>
                <h3>Email Us</h3>
                <p><?php echo $academy_email; ?></p>
              </div>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="contact-form-card" data-aos="fade-up" data-aos-delay="200">
              <?php
              if (isset($_POST['submit'])) {
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $subject = mysqli_real_escape_string($conn, $_POST['subject']);
                $message = mysqli_real_escape_string($conn, $_POST['message']);

                $sql = "INSERT INTO contacts (name, email, subject, message) 
                   VALUES ('$name', '$email', '$subject', '$message')";

                if (mysqli_query($conn, $sql)) {
                  echo "<div class='alert alert-success'>Message sent successfully!</div>";
                } else {
                  echo "<div class='alert alert-danger'>Error sending message.</div>";
                }
              }
              ?>
              <form method="POST" class="contact-form" id="contactForm">
                <div class="row">
                  <div class="col-md-6 form-group">
                    <div class="input-wrapper">
                      <input type="text" name="name" class="form-control" id="name" required>
                      <label for="name">Your Name</label>
                      <i class="bi bi-person input-icon"></i>
                    </div>
                  </div>
                  <div class="col-md-6 form-group">
                    <div class="input-wrapper">
                      <input type="email" name="email" class="form-control" id="email" required>
                      <label for="email">Your Email</label>
                      <i class="bi bi-envelope input-icon"></i>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-wrapper">
                    <input type="text" name="subject" class="form-control" id="subject" required>
                    <label for="subject">Subject</label>
                    <i class="bi bi-chat-dots input-icon"></i>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-wrapper">
                    <textarea name="message" class="form-control" rows="5" required></textarea>
                    <label for="message">Message</label>
                    <i class="bi bi-pencil input-icon"></i>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" name="submit" class="submit-btn">
                    <span>Send Message</span>
                    <i class="bi bi-send"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Contact Section -->

  </main>
  <!-- filepath: /c:/xampp/htdocs/profilee joueur/profile joueur.php -->
  <footer id="footer" class="footer">
    <div class="footer-shapes">
      <div class="shape-1"></div>
      <div class="shape-2"></div>
    </div>

    <div class="container">
      <div class="row gy-4 justify-content-between">
        <div class="col-lg-4 col-md-6">
          <div class="footer-brand">
            <img src="assets3/img/logo.png" alt="Logo" class="footer-logo">
            <h3>GFJM Academy</h3>
            <p class="mt-3">Developing tomorrow's football stars with excellence and passion.</p>
          </div>

          <div class="social-links">
            <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
            <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
            <a href="#" class="social-btn"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="footer-info">
            <h4>Contact Us</h4>
            <div class="contact-item">
              <i class="bi bi-geo-alt"></i>
              <div>
                <p>MARRAKECH</p>
                <p>Morocco</p>
              </div>
            </div>
            <div class="contact-item">
              <i class="bi bi-telephone"></i>
              <p>+212 123 456 789</p>
            </div>
            <div class="contact-item">
              <i class="bi bi-envelope"></i>
              <p>contact@frmf.ma</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="footer-newsletter">
            <h4>Newsletter</h4>
            <p>Stay updated with our latest news and updates</p>
            <form class="newsletter-form">
              <input type="email" placeholder="Enter your email">

            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <div class="copyright">
          &copy; <?php echo date('Y'); ?> <strong>GFJM Academy</strong>. All Rights Reserved
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets3/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets3/vendor/php-email-form/validate.js"></script>
  <script src="assets3/vendor/aos/aos.js"></script>
  <script src="assets3/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets3/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets3/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets3/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets3/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets3/js/main.js"></script>

</body>
<?php
// Close connection
$conn->close();
?>
</body>

</html>