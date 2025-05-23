<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FAQ</title>
  <link rel="stylesheet" href="../styles/newfaq.css" />
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
      <h1>FAQ</h1>
    </div>
  </section>

  <div class="header-section">
        <h1>Frequently Asked Questions</h1>
        <p>Find answers to common questions about requesting barangay documents online.</p>
    </div>

    <div class="faq-grid">
        <div class="faq-item">
            <h2>What documents can I request online?</h2>
            <p>You can request the following documents through our website:</p>
            <ul>
                <li>Barangay Indigency Certificate</li>
                <li>Barangay Residency Certificate</li>
                <li>Barangay Permit</li>
                <li>Barangay Clearance</li>
            </ul>
        </div>
        <div class="faq-item">
            <h2>What are the requirements for requesting a document?</h2>
            <p>Generally, you need to provide:</p>
            <ul>
                <li>A valid ID (e.g., government-issued ID, school ID)</li>
                <li>Proof of residency (e.g., utility bill, lease contract)</li>
                <li>Completed application form (available on the website)</li>
                <li>Payment for the applicable fee</li>
            </ul>
            <p>Requirements may vary depending on the specific document and barangay policies.</p>
        </div>
        <div class="faq-item">
            <h2>How long does it take to process my request?</h2>
            <p>Processing times vary by document and barangay workload. Typically, it takes 1 to 3 business days. You will receive a notification once your document is ready for pickup or delivery.</p>
        </div>
        <div class="faq-item">
            <h2>Can someone else claim the document on my behalf?</h2>
            <p>Yes, a representative can claim your document. They must present:</p>
            <ul>
                <li>A signed authorization letter from you</li>
                <li>A copy of your valid ID</li>
                <li>Their own valid ID</li>
            </ul>
        </div>
        <div class="faq-item">
            <h2>Is there a fee for requesting documents online?</h2>
            <p>Yes, there is a nominal fee for processing each document. The exact amount depends on the type of document and barangay regulations. Payment details will be provided during the request process.</p>
        </div>
        <div class="faq-item">
            <h2>How will I receive my requested document?</h2>
            <p>You can choose to:</p>
            <ul>
                <li>Pick up the document at the barangay hall</li>
                <li>Receive it via courier service (additional fees may apply)</li>
            </ul>
            <p>Select your preferred method during the application process.</p>
        </div>
        <div class="faq-item">
            <h2>What should I do if I encounter issues with my request?</h2>
            <p>If you experience any problems or have questions, please contact our support team through the "Contact Us" page. Provide your application reference number for faster assistance.</p>
        </div>
    </div>

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