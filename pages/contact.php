<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - REQWEST</title>
    <link rel="stylesheet" href="../styles/contact.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="column1">
            <img src="../assets/reqwest-logo.png" alt="Barangay Logo" class="logo">
        </div>
        <nav class="navbar">
            <a href="landing.php">Home</a>
            <a href="services.php">Services</a>
            <a href="aboutus.php">About Us</a>
            <a href="faq.php">FAQ</a>
            <a href="contact.php" class="active">Contact Us</a>
            <a href="newlogin.php">Login</a>
        </nav>
    </header>

    <div class="header-section">
        <h1>📞 Get in Touch</h1>
        <p>We're here to assist you with your barangay document requests. Reach out to us through any of the channels below.</p>
    </div>

    <div class="contact-grid">
        <div class="contact-info">
            <h2>Contact Information</h2>
            <p><strong>📍 Address:</strong> Barangay Hall, Barangay 123, Metro Manila, Philippines</p>
            <p><strong>📧 Email:</strong> <a href="mailto:support@reqwest.ph">support@reqwest.ph</a></p>
            <p><strong>📞 Phone:</strong> +63 912 345 6789</p>
            <p><strong>🕒 Office Hours:</strong> Monday to Friday, 8:00 AM – 5:00 PM</p>
            <div class="social-media">
                <a href="#" target="_blank">Facebook</a> 
                <a href="#" target="_blank">Twitter</a> 
                <a href="#" target="_blank">Instagram</a>
            </div>
        </div>

        <div class="contact-form">
            <h2>Send Us a Message</h2>
            <form action="submit_contact.php" method="POST">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <div class="map-section">
        <h2>Our Location</h2>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.123456789!2d120.987654321!3d14.5995123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b7c123456789%3A0xabcdef123456789!2sBarangay%20123%20Hall!5e0!3m2!1sen!2sph!4v1610000000000!5m2!1sen!2sph"
            width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
        </iframe>
    </div>
</body>
</html>