<?php
// Check if data was sent via POST
if (isset($_POST['userid']) && isset($_POST['password'])) {
    
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    
    // Hardcoded validation (In real apps, check against a database)
    if ($userid === "admin" && $password === "1234") {
        echo "success";
    } else {
        echo "error";
    }
}
?>