<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "lab_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if username is provided
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    
    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    // If row exists, username is found
    if ($stmt->num_rows > 0) {
        echo "exists";
    } else {
        echo "not_exists";
    }
    
    $stmt->close();
}
$conn->close();
?>