<?php
// Start session to store user data
session_start();

// --- Handle Logout ---
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy all session data
    setcookie("user", "", time() - 3600, "/"); // Delete cookie by setting past expiry
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to same page
    exit();
}

// --- Handle Login ---
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    
    // Store username in session
    $_SESSION['username'] = $username;
    
    // Set cookie (expires in 1 hour)
    setcookie("user", $username, time() + 3600, "/");
    
    echo "Session and Cookie set for $username. <br>";
}
?>

<!-- Login form -->
<form method="post">
    Username: <input type="text" name="username" required>
    <input type="submit" name="submit" value="Login">
</form>

<?php
// If user is logged in, show session, cookie, and logout link
if (isset($_SESSION['username'])) {
    echo "You are logged in as: " . $_SESSION['username'] . "<br>";
    echo "Cookie value: " . (isset($_COOKIE['user']) ? $_COOKIE['user'] : "Not set") . "<br>";
    echo "<a href='?logout=true'>Logout</a>";
}
?>