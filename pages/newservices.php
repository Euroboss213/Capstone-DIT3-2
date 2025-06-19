<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Services</title>

  <!-- Styles -->
  <link rel="stylesheet" href="../styles/newservice.css" />

  <!-- Fonts & icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=K2D:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- ── Navbar ─────────────────────────────────────────── -->
  <header class="navbar">
    <div class="logo">REQ<span>WEST</span></div>

    <nav>
      <ul>
        <li><a href="newlanding.php">Home</a></li>

        <!-- Dropdown -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle">Services <i class="fas fa-caret-down"></i></a>
          <ul class="dropdown-menu">
            <li><a href="#indigency">Barangay Indigency</a></li>
            <li><a href="#residency">Barangay Residency</a></li>
            <li><a href="#permit">Barangay Permit</a></li>
            <li><a href="#goodmoral">Barangay Good Moral</a></li>
          </ul>
        </li>

        <li><a href="newabout.php">About Us</a></li>
        <li><a href="newfaq.php">FAQ</a></li>
        <li><a href="newcontact.php">Contact Us</a></li>
        <li><a class="take-action" href="newlogin.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <!-- ── Hero banner ────────────────────────────────────── -->
  <section class="parallax-section">
    <h1>Services</h1>
  </section>

  <div class="header-section">
    <h1>Services we provide</h1>
  </div>

  <!-- ── Service cards ──────────────────────────────────── -->
  <div class="services-grid">

    <div class="service-box" id="indigency">
      <h2>Request Barangay Indigency</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      <a href="#" id="openIndigency" class="btn-small">Learn More</a>
    </div>

    <div class="service-box" id="residency">
      <h2>Request Barangay Residency</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      <a href="#" id="openResidency" class="btn-small">Learn More</a>
    </div>

    <div class="service-box" id="permit">
      <h2>Request Barangay Permit</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      <a href="#" id="openPermit" class="btn-small">Learn More</a>
    </div>

    <div class="service-box" id="goodmoral">
      <h2>Request Barangay Good Moral</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      <a href="#" id="openGoodMoral" class="btn-small">Learn More </a>
    </div>

  </div>

  <!-- ── Indigency Modal ───────────────────────────────── -->
  <div id="indigencyModal" class="modal">
    <div class="modal-content">
      <button class="close-btn" aria-label="Close">×</button>

      <h2>Certificate of Indigency</h2>
      <hr>

      <p>
        A Certificate of Indigency is issued to residents who are classified as
        low‑income or financially disadvantaged.
      </p>

      <h4>Uses</h4>
      <ul>
        <li>Apply for scholarships or educational financial aid.</li>
        <li>Request medical assistance from hospitals or government programs.</li>
        <li>Support employment applications or legal claims.</li>
        <li>Qualify for government subsidy programs like PhilHealth or DSWD aid.</li>
      </ul>
    </div>
  </div>

  <!-- ── Residency Modal ───────────────────────────────── -->
  <div id="residencyModal" class="modal">
    <div class="modal-content">
      <button class="close-btn" aria-label="Close">×</button>

      <h2>Certificate of Residency</h2>
      <hr>

      <p>
        The Certificate of Residency certifies that a person is a resident of the barangay.
      </p>

      <h4>Uses</h4>
      <ul>
        <li>Employment or job applications.</li>
        <li>Enrolling children in local schools.</li>
        <li>Processing permits or licenses.</li>
        <li>Legal or court matters proving residency.</li>
      </ul>
    </div>
  </div>

  <!-- ── Permit Modal ───────────────────────────────── -->
  <div id="permitModal" class="modal">
    <div class="modal-content">
      <button class="close-btn" aria-label="Close">×</button>

      <h2>Barangay Permit</h2>
      <hr>

      <p>
        A Barangay Permit is an official document needed to conduct business or certain events within the barangay.
      </p>

      <h4>Uses</h4>
      <ul>
        <li>School requirements such as enrollment and clearances.</li>
        <li>Travel documentation including local and international travel.</li>
        <li>Employment-related clearances and job applications.</li>
      </ul>
    </div>
  </div>

  <!-- ── Good Moral Modal ───────────────────────────────── -->
  <div id="goodMoralModal" class="modal">
    <div class="modal-content">
      <button class="close-btn" aria-label="Close">×</button>

      <h2>Certificate of Good Moral</h2>
      <hr>

      <p>
        This document affirms that a resident has maintained good behavior and has no derogatory records in the barangay.
      </p>

      <h4>Uses</h4>
      <ul>
        <li>School admissions or scholarship applications.</li>
        <li>Employment verification and character references.</li>
        <li>Visa applications and overseas travel requirements.</li>
        <li>Local government clearances and job permits.</li>
      </ul>
    </div>
  </div>

  <!-- ── Footer ─────────────────────────────────────────── -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section about">
        <h3>About Us</h3>
        <div class="about-content">
          <img src="../assets/brgy-logo.png" alt="Barangay Logo" class="footer-logo" />
          <p class="footer-description">
            Barangay West Kamias will be empowered and transformed into a productive,
            self‑reliant, responsible, humane, and upright community for the betterment of society.
          </p>
        </div>
      </div>

      <div class="footer-section contact">
        <h3>Get In Touch!</h3>
        <p><i class="fas fa-mobile-alt"></i> 09123456789</p>
        <p><i class="fas fa-phone-alt"></i> (012) 345-6789</p>
        <p><i class="fas fa-map-marker-alt"></i> West Kamias, Quezon City</p>
        <p><i class="fas fa-envelope"></i> info@barangayzone2.com</p>
      </div>

      <div class="footer-section social-icons">
        <h3>Follow Us</h3>
        <div class="social-links">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-x-twitter"></i></a>
        </div>
      </div>
    </div>
  </footer>

  <div class="footer-bottom">
    © 2025 Barangay West Kamias | Quezon City. All Rights Reserved. Designed by DIT 3-2 Group 2.
  </div>

  <!-- ── Scroll-to-Top Button ───────────────────────────── -->
  <button onclick="scrollToTop()" id="scrollTopBtn" title="Go to top">↑</button>

  <!-- ── Scripts ────────────────────────────────────────── -->
  <script src="../js/services_popup.js" defer></script>

</body>
</html>