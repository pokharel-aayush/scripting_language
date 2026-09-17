<?php
$errors = [];
$success = "";

// Preserve input values
$name = $address = $username = $email = $website = $phone = $gender = $course = "";

if (isset($_POST['submit'])) {
    $name     = trim($_POST['name']);
    $address  = trim($_POST['address']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $website  = trim($_POST['website']);
    $phone    = trim($_POST['phone']);
    $gender   = $_POST['gender'] ?? '';
    $course   = $_POST['course'] ?? '';

    // 1. Name Validation
    if (empty($name)) {
        $errors[] = "Name must not be empty.";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errors[] = "Name can only contain alphabetic characters and spaces.";
    }

    // 2. Address Validation
    if (empty($address)) {
        $errors[] = "Address must not be empty.";
    }

    // 3. Username Validation
    if (empty($username)) {
        $errors[] = "Username must not be empty.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
        $errors[] = "Username can only contain letters, numbers, and underscores.";
    }

    // 4. Email Validation
    if (empty($email)) {
        $errors[] = "Email must not be empty.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // 5. Password Validation
    if (empty($password)) {
        $errors[] = "Password must not be empty.";
    } else {
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter.";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter.";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one digit.";
        }
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = "Password must contain at least one special character.";
        }
    }

    // 6. Website Validation
    if (empty($website)) {
        $errors[] = "Website must not be empty.";
    } elseif (!filter_var($website, FILTER_VALIDATE_URL)) {
        $errors[] = "Invalid website URL. Please include http:// or https://";
    }

    // 7. Phone Validation
    if (empty($phone)) {
        $errors[] = "Phone must not be empty.";
    } elseif (!preg_match("/^(96|97|98)[0-9]{8}$/", $phone)) {
        $errors[] = "Phone must be exactly 10 digits and start with 96, 97, or 98.";
    }

    // 8. Gender Validation
    if (empty($gender)) {
        $errors[] = "Please select a gender.";
    }

    // 9. Course Validation
    if (empty($course)) {
        $errors[] = "Please select a course.";
    }

    // Success Message
    if (empty($errors)) {
        $success = "<b>Registration Successful! All data validated correctly.</b>";
    }
}
?>

<h3>Registration Form</h3>

<?php 
if (!empty($errors)) {
    echo "<b>Validation Errors:</b><br>";
    foreach ($errors as $error) {
        echo "- " . $error . "<br>";
    }
    echo "<br>";
}
if (!empty($success)) {
    echo $success . "<br><br>";
}
?>

<!-- FORM -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <td><label>Name:</label></td>
            <td><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></td>
        </tr>
        <tr>
            <td><label>Address:</label></td>
            <td><textarea name="address" rows="3" cols="30"><?php echo htmlspecialchars($address); ?></textarea></td>
        </tr>
        <tr>
            <td><label>Username:</label></td>
            <td><input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"></td>
        </tr>
        <tr>
            <td><label>Email:</label></td>
            <td><input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>"></td>
        </tr>
        <tr>
            <td><label>Password:</label></td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td><label>Website:</label></td>
            <td><input type="text" name="website" placeholder="http://example.com" value="<?php echo htmlspecialchars($website); ?>"></td>
        </tr>
        <tr>
            <td><label>Phone:</label></td>
            <td><input type="text" name="phone" placeholder="98XXXXXXXX" value="<?php echo htmlspecialchars($phone); ?>"></td>
        </tr>
        <tr>
            <td><label>Gender:</label></td>
            <td>
                <input type="radio" name="gender" value="Male" <?php if($gender == 'Male') echo 'checked'; ?>> Male
                <input type="radio" name="gender" value="Female" <?php if($gender == 'Female') echo 'checked'; ?>> Female
                <input type="radio" name="gender" value="Other" <?php if($gender == 'Other') echo 'checked'; ?>> Other
            </td>
        </tr>
        <tr>
            <td><label>Course:</label></td>
            <td>
                <select name="course">
                    <option value="">-- Select Course --</option>
                    <option value="BCA" <?php if($course == 'BCA') echo 'selected'; ?>>BCA</option>
                    <option value="BBA" <?php if($course == 'BBA') echo 'selected'; ?>>BBA</option>
                    <option value="BSc CSIT" <?php if($course == 'BSc CSIT') echo 'selected'; ?>>BSc CSIT</option>
                    <option value="BE" <?php if($course == 'BE') echo 'selected'; ?>>BE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="submit" value="Register">
            </td>
        </tr>
    </table>
</form>