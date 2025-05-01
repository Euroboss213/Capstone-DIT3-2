<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Sign Up</h1>
        <form action="../php/tosignup.php" method="POST">
            <label for="first-name">First Name</label>
            <input type="text" name="first-name" required>

            <label for="middle-name">Middle Name</label>
            <input type="text" name="middle-name" >

            <label for="last-name">Last Name</label>
            <input type="text" name="last-name" required>

            <label for="suffix">Suffix</label>
            <input type="text" name="suffix" >

            <label for="username">Username</label>
            <input type="email" name="username" required>

            <label for="password">Password</label>
            <input 
                type="password" 
                name="password" 
                required 
                pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,><#^()])[A-Za-z\d@$!%*?&]{8,}$" 
                title="Password must be at least 8 characters long, include one uppercase letter, one number, and one special character."
            >

            <button type="submit">Sign Up</button>
        </form>

</body>
</html>