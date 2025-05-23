<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Landing Page</title>
  <link rel="stylesheet" href="../styles/newlanding.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <!-- Header -->
  <header class="navbar">
    <div class="logo">REQ<span>WEST</span></div>
    <nav>
      <ul>
        <li><a href="newlanding.php">Home</a></li>
        <li><a href="newservices.php">Services</a></li>
        <li><a href="newabout.php">About Us</a></li>
        <li><a href="newfaq.php">FAQ</a></li>
        <li><a href="newcontact.php">Contact Us</a></li>
        <li><a class="take-action" href="newlogin.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero" data-aos="fade-up">
    <div class="content">
      <h1>Barangay Document Request System</h1>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce placerat id neque vitae mattis. In a tortor lectus. Pellentesque tortor ex, efficitur a felis eu, ullamcorper laoreet nisi. Proin lobortis.
      </p>
      <a href="aboutus.php" class="learn-more">Learn More</a>
    </div>
  </section>

  <!-- Info Section -->
  <section class="info" data-aos="fade-left">
    <div class="logo-container">
      <img src="../assets/reqwest-logo.png" alt="Equichem Logo" />
      <p class="equichem-tagline">"Barangay Document Request System"</p>
    </div>
    <div class="text">
      <h2>25 Long Years Of Manufacturing Excellence With Quality At It's Best!</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tincidunt mi tortor, eget dapibus mauris facilisis vel. Aenean lobortis ultricies nibh, a condimentum neque semper quis. Aenean elit felis, sollicitudin ac tellus suscipit, dictum aliquet diam. Donec faucibus ex lacus, at euismod lacus pulvinar eget. Pellentesque in nunc sit amet augue luctus egestas at ac risus. Aenean id diam at.
      </p>
      <a href="aboutus.php" class="learn-more">Learn More</a>
    </div>
  </section>

  <!-- Barangay Officials Section -->
  <section class="officials" data-aos="fade-right">
    <div class="officials-text">
      <h2>Meet Our Barangay Officials</h2>
      <p>
        Our dedicated team is committed to serving the community with integrity, transparency, and efficiency.
      </p>
    </div>
    <div class="officials-grid">
      <!-- 10 Officials -->
      <div class="official-card" data-aos="zoom-in" data-aos-delay="100">
        <img src="../assets/member1.jpg" alt="Official 1">
        <h3>Juan Dela Cruz</h3>
        <p>Barangay Captain</p>
      </div>
      <div class="official-card" data-aos="zoom-in" data-aos-delay="150">
        <img src="../assets/member2.jpg" alt="Official 2">
        <h3>Maria Santos</h3>
        <p>Kagawad</p>
      </div>
      <div class="official-card" data-aos="zoom-in" data-aos-delay="200">
        <img src="../assets/member3.jpg" alt="Official 3">
        <h3>Jose Ramirez</h3>
        <p>Kagawad</p>
      </div>
      <div class="official-card" data-aos="zoom-in" data-aos-delay="350">
        <img src="../assets/member6.jpg" alt="Official 6">
        <h3>Gloria Mendez</h3>
        <p>Kagawad</p>
      </div>
      <div class="official-card" data-aos="zoom-in" data-aos-delay="400">
        <img src="../assets/member7.jpg" alt="Official 7">
        <h3>Pedro Cruz</h3>
        <p>Secretary</p>
      </div>
      <div class="official-card" data-aos="zoom-in" data-aos-delay="450">
        <img src="../assets/member8.jpg" alt="Official 8">
        <h3>Lucia Rivera</h3>
        <p>Treasurer</p>
      </div>
      <div class="official-card" data-aos="zoom-in" data-aos-delay="500">
        <img src="../assets/member9.jpg" alt="Official 9">
        <h3>Ramon Torres</h3>
        <p>SK Chairman</p>
      </div>
      <div class="official-card" data-aos="zoom-in" data-aos-delay="550">
        <img src="../assets/member10.jpg" alt="Official 10">
        <h3>Isabel Cruz</h3>
        <p>Tanod Chief</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section about">
        <h3>About Us</h3>
        <div class="footer-section about-content">
          <img src="../assets/brgy-logo.png" alt="Barangay Logo" class="footer-logo" />
          <p class="footer-description">
            Barangay West Kamias will be empowered and transformed into a productive, self-reliant, responsible, humane, and upright community for the betterment of society.
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

  <!-- Scroll to Top Button -->
  <button onclick="scrollToTop()" id="scrollTopBtn" title="Go to top">↑</button>

  <!-- Scripts -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ once: true, offset: 200, duration: 1000 });

    const scrollBtn = document.getElementById("scrollTopBtn");
    window.onscroll = () => {
      scrollBtn.style.display = window.scrollY > 300 ? "block" : "none";
    };
    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    }

    // Highlight active nav link
    const current = location.pathname.split("/").pop();
    document.querySelectorAll("nav a").forEach(link => {
      if (link.getAttribute("href") === current) {
        link.classList.add("active");
      }
    });
  </script>
</body>
</html>