<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "lab_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $dob = trim($_POST['dob']);
    $phone = trim($_POST['phone']);
    $errors = [];

    // a. Username validation (minimum 8 characters)
    if (strlen($username) < 8) {
        $errors[] = "Username must be at least 8 characters.";
    }
    
    // b. Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    // c. DOB validation (Format: YYYY-MM-DD)
    $date = DateTime::createFromFormat('Y-m-d', $dob);
    if (!$date || $date->format('Y-m-d') !== $dob) {
        $errors[] = "Invalid Date of Birth format. Use YYYY-MM-DD.";
    }
    
    // d. Phone validation (exactly 10 digits)
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Phone number must be exactly 10 digits.";
    }

    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO users (username, email, dob, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $dob, $phone);
        
        if ($stmt->execute()) {
            $message = "<span style='color:green;'><strong>Registration Successful for $username!</strong></span>";
        } else {
            $message = "<span style='color:red;'>Database Error: " . $stmt->error . "</span>";
        }
        $stmt->close();
    } else {
        foreach ($errors as $error) {
            $message .= "<span style='color:red;'>Error: $error</span><br>";
        }
    }
}
$conn->close();
?>

<h3>User Registration</h3>
<form method="post">
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td><label>Username (min 8 chars):</label></td>
            <td><input type="text" name="username" required></td>
        </tr>
        <tr>
            <td><label>Email:</label></td>
            <td><input type="text" name="email" required></td>
        </tr>
        <tr>
            <td><label>Date of Birth (YYYY-MM-DD):</label></td>
            <td><input type="text" name="dob" placeholder="2000-01-01" required></td>
        </tr>
        <tr>
            <td><label>Phone (10 digits):</label></td>
            <td><input type="text" name="phone" required></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="submit" value="Register">
            </td>
        </tr>
    </table>
</form>
<br>
<?php echo $message; ?>