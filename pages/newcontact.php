<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us</title>
  <link rel="stylesheet" href="../styles/newcontact.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
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

  <section class="parallax-section">
    <div class="container">
      <h1>Contact Us</h1>
    </div>
  </section>

  <section class="support-inquiries">
  <div class="content-wrapper">
    <div class="info-section">
      <h2>Support & Inquiries</h2>
      <p>
        Looking for high-quality chemicals, products, and equipment? We've got you covered! Contact us for inquiries, quotations, or expert advice.
      </p>
      <ul>
        <li><i class="fas fa-map-marker-alt"></i> 2 K-10th, Cubao, Quezon City, 1109 Metro Manila</li>
        <li><i class="fas fa-envelope"></i> sales@equichem.ph</li>
        <li><i class="fas fa-phone"></i> 0966 665 0728</li>
        <li><i class="fab fa-facebook"></i> EquiChem Pest Control Equipment</li>
      </ul>
    </div>
    <div class="form-section">
      <form>
        <div class="form-group">
          <label for="name">Name *</label>
          <div class="name-fields">
            <input type="text" id="first-name" placeholder="First Name" required>
            <input type="text" id="last-name" placeholder="Last Name" required>
          </div>
        </div>
        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" id="email" placeholder="Email Address" required>
        </div>
        <div class="form-group">
          <label for="number">Number</label>
          <input type="tel" id="number" placeholder="Phone Number">
        </div>
        <div class="form-group">
          <label for="message">Comment or Message</label>
          <textarea id="message" placeholder="Let us know your thoughts!"></textarea>
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>
  
  <div class="map-section">
  <h2>You can visit us here!</h2>
  <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.123456789!2d121.0525!3d14.6195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c83f0f0f0f0f%3A0xabcdef1234567890!2s2%20K-10th%2C%20Cubao%2C%20Quezon%20City%2C%201109%20Metro%20Manila%2C%20Philippines!5e0!3m2!1sen!2sph!4v1715263200000!5m2!1sen!2sph"
      width="100%" height="500" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
  </iframe>
</div>

</section>


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

  <script>
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
