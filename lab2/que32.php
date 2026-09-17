<?php
session_start();

// Database Connection
$conn = new mysqli("localhost", "root", "", "lab_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$current_page = htmlspecialchars($_SERVER['PHP_SELF']);

// Read session message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Handle Form Submission
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $roll = intval($_POST['roll']);
    $web_tech = intval($_POST['web_tech']);
    $dbms = intval($_POST['dbms']);
    $economics = intval($_POST['economics']);
    $dsa = intval($_POST['dsa']);
    $account = intval($_POST['account']);
    
    // Validation
    if (empty($name) || $roll <= 0) {
        $_SESSION['message'] = "<b>Error: Name and a valid Roll number are required.</b>";
        header("Location: $current_page");
        exit();
    } elseif ($web_tech < 0 || $dbms < 0 || $economics < 0 || $dsa < 0 || $account < 0) {
        $_SESSION['message'] = "<b>Error: Marks cannot be negative.</b>";
        header("Location: $current_page");
        exit();
    } else {
        // Calculate Total
        $total = $web_tech + $dbms + $economics + $dsa + $account;
        
        // Determine Result (Fail if any subject is less than 40)
        $isFail = ($web_tech < 40 || $dbms < 40 || $economics < 40 || $dsa < 40 || $account < 40);
        $result = $isFail ? "Fail" : "Pass";
        
        // Insert into Database
        $sql = "INSERT INTO marks (name, roll, web_tech, dbms, economics, dsa, account, total, result, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiiiiiis", $name, $roll, $web_tech, $dbms, $economics, $dsa, $account, $total, $result);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "<b>Mark sheet generated successfully for $name!</b>";
        } else {
            $_SESSION['message'] = "<b>Database Error: " . $stmt->error . "</b>";
        }
        $stmt->close();
        
        // Redirect to prevent duplicate entries on refresh
        header("Location: $current_page");
        exit();
    }
}
?>

<h3>Generate Mark Sheet</h3>

<?php if (!empty($message)) echo $message . "<br><br>"; ?>

<!-- FORM -->
<form method="post" action="<?php echo $current_page; ?>">
    <label>Student Name:</label><br>
    <input type="text" name="name" required><br><br>
    
    <label>Roll Number:</label><br>
    <input type="number" name="roll" required><br><br>
    
    <b>Enter Marks (Out of 100):</b><br><br>
    
    <label>Web Tech II:</label><br>
    <input type="number" name="web_tech" min="0" max="100" required><br><br>
    
    <label>DBMS:</label><br>
    <input type="number" name="dbms" min="0" max="100" required><br><br>
    
    <label>Economics:</label><br>
    <input type="number" name="economics" min="0" max="100" required><br><br>
    
    <label>DSA:</label><br>
    <input type="number" name="dsa" min="0" max="100" required><br><br>
    
    <label>Account:</label><br>
    <input type="number" name="account" min="0" max="100" required><br><br>
    
    <input type="submit" name="submit" value="Generate Mark Sheet">
</form>

<hr>

<!-- DISPLAY MARK SHEET -->
<h3>Generated Mark Sheets</h3>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Roll</th>
        <th>Web Tech II</th>
        <th>DBMS</th>
        <th>Economics</th>
        <th>DSA</th>
        <th>Account</th>
        <th>Total</th>
        <th>Result</th>
        <th>Date</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM marks ORDER BY id DESC");
    
    if ($result === false) {
        echo "<tr><td colspan='11'>Database Error: " . $conn->error . "</td></tr>";
    } elseif ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Determine row color based on result
            if ($row['result'] == 'Pass') {
                $row_color = "#00FF00"; // Bright Green
            } else {
                $row_color = "#FF0000"; // Bright Red
            }
            
            echo "<tr style='background-color: $row_color;'>
                    <td>" . $row['id'] . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . $row['roll'] . "</td>
                    <td>" . $row['web_tech'] . "</td>
                    <td>" . $row['dbms'] . "</td>
                    <td>" . $row['economics'] . "</td>
                    <td>" . $row['dsa'] . "</td>
                    <td>" . $row['account'] . "</td>
                    <td><b>" . $row['total'] . "</b></td>
                    <td><b>" . $row['result'] . "</b></td>
                    <td>" . $row['created_at'] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No mark sheets generated yet.</td></tr>";
    }
    $conn->close();
    ?>
</table>