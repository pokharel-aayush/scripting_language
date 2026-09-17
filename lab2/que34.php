<?php
$message = "";
$success = false;
$si = 0;
$total = 0;
$principal = "";
$rate = "";
$time = "";

if (isset($_POST['submit'])) {
    $principal = $_POST['principal'];
    $rate = $_POST['rate'];
    $time = $_POST['time'];
    
    // Validation
    if (!is_numeric($principal) || !is_numeric($rate) || !is_numeric($time)) {
        $message = "<b>Error: Please enter valid numeric values.</b>";
    } elseif ($principal <= 0 || $rate <= 0 || $time <= 0) {
        $message = "<b>Error: Values must be greater than zero.</b>";
    } else {
        // Calculate Simple Interest
        $si = ($principal * $rate * $time) / 100;
        $total = $principal + $si;
        
        $success = true; // Set flag to true
        $message = "<b>Calculation Successful!</b>";
    }
}
?>

<h3>Simple Interest Calculator</h3>

<?php if (!empty($message)) echo $message . "<br><br>"; ?>

<!-- FORM -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label>Principal Amount (P):</label><br>
    <input type="text" name="principal" value="<?php echo htmlspecialchars($principal); ?>" required><br><br>
    
    <label>Rate of Interest (R) in %:</label><br>
    <input type="text" name="rate" value="<?php echo htmlspecialchars($rate); ?>" required><br><br>
    
    <label>Time Period (T) in years:</label><br>
    <input type="text" name="time" value="<?php echo htmlspecialchars($time); ?>" required><br><br>
    
    <input type="submit" name="submit" value="Calculate Simple Interest">
</form>

<hr>

<!-- DISPLAY RESULT -->
<?php if ($success): ?>
    <h3>Result</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <td><b>Principal Amount</b></td>
            <td><?php echo number_format($principal, 2); ?></td>
        </tr>
        <tr>
            <td><b>Rate of Interest</b></td>
            <td><?php echo $rate; ?>%</td>
        </tr>
        <tr>
            <td><b>Time Period</b></td>
            <td><?php echo $time; ?> years</td>
        </tr>
        <tr>
            <td><b>Simple Interest</b></td>
            <td><?php echo number_format($si, 2); ?></td>
        </tr>
        <tr>
            <td><b>Total Amount (P + SI)</b></td>
            <td><b><?php echo number_format($total, 2); ?></b></td>
        </tr>
    </table>
<?php endif; ?>