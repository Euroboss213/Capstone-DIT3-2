<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barangay West Kamias</title>
    <link rel="stylesheet" href="../styles/landing.css">
    <script src="../js/landing-image-slider.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="column1">
            <div class="barangay-title">
                <img src="../assets/reqwest-logo.png" alt="Barangay Logo" class="logo">
            </div>
        </div>
        <nav class="navbar">
            <a href="landing.php" class="active">Home</a>
            <a href="services.php">Services</a>
            <a href="aboutus.php">About Us</a>
            <a href="faq.php">FAQ</a>
            <a href="contact.php">Contact Us</a>
            <a href="newlogin.php">Login</a>
        </nav>
    </header>

    <div class="slider">
        <img id="slider-image" src="../assets/landing-bg.png" alt="Slider Image">
        <div class="indicator-container">
            <span class="dot active" onclick="currentImage(0)"></span>
            <span class="dot" onclick="currentImage(1)"></span>
            <span class="dot" onclick="currentImage(2)"></span>
            <span class="dot" onclick="currentImage(3)"></span>
        </div>
    </div>

    <div class="officials">
        <h1 class="title">BARANGAY<br>OFFICIALS</h1>
        <div class="members">
            <div class="member">
                <img src="../assets/member1.jpg" alt="Deovic Ontangco">
                <h2>Hon. Deovic Ontangco</h2>
                <p>Barangay Captain</p>
            </div>
            <div class="member">
                <img src="../assets/member2.jpg" alt="Robenson Sale">
                <h2>Hon. Robenson Sale</h2>
                <p>City Councilor</p>
            </div>
            <div class="member">
                <img src="../assets/member3.jpg" alt="Prima Dajoyag">
                <h2>Hon. Prima Dajoyag</h2>
                <p>City Councilor</p>
            </div>
            <div class="member">
                <img src="../assets/member4.jpg" alt="Michael Jones Salazar">
                <h2>Hon. Michael Jones Salazar</h2>
                <p>City Councilor</p>
            </div>
            <div class="member">
                <img src="../assets/member5.jpg" alt="Rexner Jown Pastoral">
                <h2>Hon. Rexner Jown Pastoral</h2>
                <p>City Councilor</p>
            </div>
            <div class="member">
                <img src="../assets/member6.jpg" alt="Divina Opelanio">
                <h2>Hon. Divina Opelanio</h2>
                <p>City Councilor</p>
            </div>
            <div class="member">
                <img src="../assets/member7.jpg" alt="Caesar Ryan Noche">
                <h2>Hon. Caesar Ryan Noche</h2>
                <p>City Councilor</p>
            </div>
            <div class="member">
                <img src="../assets/member8.jpg" alt="Cedric De Joya">
                <h2>Hon. Cedric De Joya</h2>
                <p>City Councilor</p>
            </div>
            <div class="member">
                <img src="../assets/member9.jpg" alt="Generoso Garcia">
                <h2>Hon. Generoso Garcia</h2>
                <p>ABC President</p>
            </div>
            <div class="member">
                <img src="../assets/member10.jpg" alt="Rodellen Mendoza">
                <h2>Hon. Rodellen Mendoza</h2>
                <p>SK Federation President</p>
            </div>
        </div>
    </div>

    <footer class="footer">
    <div class="footer-content">
        <div class="footer-section about">
            <h3>About Us</h3>
            <div class="footer-section about-content">
                <img src="../assets/brgy-logo.png" alt="Barangay Logo" class="footer-logo">
                <p class="footer-description">
                    Barangay West Kamias will be empowered and transformed into a productive, self-reliant, responsible, humane, and upright community for the betterment of society.
                </p>
            </div>
        </div>
        <div class="footer-section contact">
            <h3>Get In Touch!</h3> <!-- Added heading for consistency -->
            <p><i class="fas fa-mobile-alt"></i> 09123456789</p>
            <p><i class="fas fa-phone-alt"></i> (012) 345-6789</p>
            <p><i class="fas fa-map-marker-alt"></i> West Kamias, Quezon City</p>
            <p><i class="fas fa-envelope"></i> info@barangayzone2.com</p>
        </div>
        <div class="footer-section social-icons">
            <h3>Follow Us</h3> <!-- Added heading for consistency -->
            <div class="social-links">
                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fab fa-x-twitter"></i></a>
            </div>
        </div>
    </div>
</footer>

    <div class="footer-bottom">
        © 2025 Barangay West Kamias | Quezon City. All Rights Reserved. Designed by DIT 3-2 Group 2.
    </div>
</body>
</html>