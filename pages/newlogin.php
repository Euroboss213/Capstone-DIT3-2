<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Form</title>
    <!--STYLES-->
    <link rel="stylesheet" href="../styles/newlogin.css">
    <!--FONTS-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <!--SCRIPTS-->
    <script src="../js/confirmPass.js"></script>
</head>
<body>
    <div class="container">
        <div class="form-box login">
            <form action="../php/tologin.php" method="POST" id="login-form">
                <div class="navbar">
                    <a href="#">Services</a>
                    <a href="#">About Us</a>
                    <a href="#">FAQ</a>
                    <a href="#">Contact Us</a>  
                </div>
                <img src = "../assets/reqwest-logo.png">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="email" placeholder="Email" required name="username">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" required name="password">
                    <i class='bx bxs-lock-alt' ></i>
                </div>
                <div class="forgot-link">
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>

        <div class="form-box register">
            <form action="../php/tosignup.php" method="POST" id="signup-form">
                <div class="input-box">
                    <input type="text" name="first-name" placeholder="First Name" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="middle-name" placeholder="Middle Name">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="last-name" placeholder="Last Name" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="suffix" placeholder="Suffix">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" name="username" placeholder="Email" required>
                    <i class='bx bxs-envelope'></i>
                </div>

                <div class="passcontainer">
                    <div class="input-box">
                        <input type="password" name="password" id="password" placeholder="Password" required
                            pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,><#^()])[A-Za-z\d@$!%*?&]{8,}$">
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                </div>

                <div class="idcontainer">
                    <div class="id-options-box">
                        <select class="id" name="id_type" id="id">
                            <option value="nationalid">National ID</option>
                            <option value="philhealthid">Philhealth ID</option>
                            <option value="sssid">SSS ID</option>
                            <option value="tinid">TIN ID</option>
                            <option value="votersid">Voter's ID</option>
                        </select>
                    </div>
                    <div class="id-input-box">
                        <input type="text" placeholder="ID Number" name="selected_id" id="selected-id" required class="id-input">
                    </div>
                </div>
                    <button type="submit" class="btn">Register</button>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h2>Welcome Back!</h2>
                <p>Don't have an account?</p>
                <button class="btn register-btn">Register</button>
            </div>

            <div class="toggle-panel toggle-right">
                
                <h1>Registration</h1>
                <h2>Hello, Welcome!</h2>
                <p>Already have an account?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>
    </div>

    <script src="../js/newlogin.js"></script>
    
</body>
</html>