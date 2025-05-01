<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- STYLES -->
    <link rel="stylesheet" href="../styles/login.css">
    <!-- FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <script src="../js/loginToSignup.js"></script>
</head>
<body>
<nav>
        <img src="../assets/reqwest-logo.png" alt="reqwest-logo">
        <ul class="navigation">
            <li>Home</li>
            <li>Services</li>
            <li>About Us</li>
            <li>FAQ</li>
            <li>Contact Us</li>
        </ul>
    </nav>
    <main>
        <div class="left-cont">
            <div class="headers">
                <div class="login-page">
                    <h1 id="login-header" class="header-inactive">Login</h1>
                </div>
                <div class="signup-page">
                    <h1 id="signup-header" class="header-active">Signup</h1> 
                </div>              
            </div>
            <!-- Login form -->
            <form action="../php/tologin.php" method="POST" class="login-form" id="login-form">
                <input type="email" name="username" placeholder="username@gmail.com" required>
                <input type="password" name="password" placeholder="********" required>
                
                <div class="login-form-bot-cont">
                    <a href="#">Forgot Password?</a>
                    <button type="submit">Login</button>
                </div>
            </form>
            <!-- Signup form -->
            <form action="../php/tosignup.php" method="POST" class="signup-form" id="signup-form">
                <label for="first-name">First Name</label>
                <label for="middle-name">Middle Name</label>
                <input type="text" name="first-name" required placeholder="John">
                <input type="text" name="middle-name" placeholder="Doe">

                <label for="last-name">Last Name</label>
                <label for="suffix">Suffix</label>
                <input type="text" name="last-name" required placeholder="Kleng">
                <input type="text" name="suffix" placeholder="Jr.">

                <label for="username">Username</label>
                <label for="password">Password</label>
                <input type="email" name="username" required placeholder="Jdk@gmail.com">
                <input 
                    type="password" 
                    name="password" 
                    required
                    placeholder="**********"
                    pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,><#^()])[A-Za-z\d@$!%*?&]{8,}$" 
                    title="Password must be at least 8 characters long, include one uppercase letter, one number, and one special character."
                >

                    <a href="#">Forgot Password?</a>
                    <button type="submit">Signup</button>
            </form>
        </div>
        <div class="right-cont">
            <div class="circle big"></div>
            <div class="circle medium"></div>
            <div class="circle small"></div>
        </div>

    </main>
    
</body>
</html>