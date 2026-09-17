<!-- Login form to accept username and password -->
<form method="post">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" name="submit" value="Login">
</form>

<?php
// Check if form is submitted
if (isset($_POST['submit'])) {
    
    // Get username and password from form
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Predefined valid credentials
    $valid_user = "admin";
    $valid_pass = "password123";
    
    // Check if entered credentials match the valid ones
    if ($username === $valid_user && $password === $valid_pass) {
        echo "Login Successful! Welcome, $username.";
    } else {
        echo "Invalid Username or Password.";
    }
}
?>