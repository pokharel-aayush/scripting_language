<?php
$message = "";
$success = false;

if (isset($_POST['submit'])) {
    $income = floatval($_POST['income']);
    $gender = $_POST['gender'];
    
    if ($income < 0) {
        $message = "<b>Error: Income cannot be negative.</b>";
    } else {
        $success = true;
        $total_tax = 0;
        $breakdown = [];
        
        // Slab 1: Up to 1,000,000 (1%)
        if ($income > 0) {
            $taxable = min($income, 1000000);
            $tax = $taxable * 0.01;
            $total_tax += $tax;
            $breakdown[] = "1% on NPR " . number_format($taxable, 2) . " = NPR " . number_format($tax, 2);
        }
        
        // Slab 2: Next 500,000 (10%)
        if ($income > 1000000) {
            $taxable = min($income - 1000000, 500000);
            $tax = $taxable * 0.10;
            $total_tax += $tax;
            $breakdown[] = "10% on NPR " . number_format($taxable, 2) . " = NPR " . number_format($tax, 2);
        }
        
        // Slab 3: Next 1,000,000 (20%)
        if ($income > 1500000) {
            $taxable = min($income - 1500000, 1000000);
            $tax = $taxable * 0.20;
            $total_tax += $tax;
            $breakdown[] = "20% on NPR " . number_format($taxable, 2) . " = NPR " . number_format($tax, 2);
        }
        
        // Slab 4: Next 1,500,000 (27%)
        if ($income > 2500000) {
            $taxable = min($income - 2500000, 1500000);
            $tax = $taxable * 0.27;
            $total_tax += $tax;
            $breakdown[] = "27% on NPR " . number_format($taxable, 2) . " = NPR " . number_format($tax, 2);
        }
        
        // Slab 5: Above 4,000,000 (29%)
        if ($income > 4000000) {
            $taxable = $income - 4000000;
            $tax = $taxable * 0.29;
            $total_tax += $tax;
            $breakdown[] = "29% on NPR " . number_format($taxable, 2) . " = NPR " . number_format($tax, 2);
        }
        
        // Apply 10% discount for female taxpayers
        $discount = 0;
        if (strtolower($gender) == 'female') {
            $discount = $total_tax * 0.10;
            $total_tax -= $discount;
        }
        
        $net_income = $income - $total_tax;
    }
}
?>

<h3>Income Tax Calculator (FY 2083/84)</h3>

<?php if (!empty($message)) echo $message . "<br><br>"; ?>

<!-- FORM -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <td><label>Annual Taxable Income (NPR):</label></td>
            <td><input type="text" name="income" required></td>
        </tr>
        <tr>
            <td><label>Gender:</label></td>
            <td>
                <input type="radio" name="gender" value="male" required> Male
                <input type="radio" name="gender" value="female"> Female
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="submit" value="Calculate Tax">
            </td>
        </tr>
    </table>
</form>

<hr>

<!-- DISPLAY RESULT -->
<?php if ($success): ?>
    <h3>Tax Calculation Summary</h3>
    
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <td><b>1. Annual Taxable Income</b></td>
            <td>NPR <?php echo number_format($income, 2); ?></td>
        </tr>
        <tr>
            <td valign="top"><b>2. Tax Breakdown</b></td>
            <td>
                <?php 
                if (empty($breakdown)) {
                    echo "No tax applicable.";
                } else {
                    foreach ($breakdown as $line) {
                        echo $line . "<br>";
                    }
                }
                ?>
            </td>
        </tr>
        <?php if (strtolower($gender) == 'female'): ?>
        <tr>
            <td><b>Female Discount (10%)</b></td>
            <td>- NPR <?php echo number_format($discount, 2); ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td><b>3. Total Tax Payable</b></td>
            <td><b>NPR <?php echo number_format($total_tax, 2); ?></b></td>
        </tr>
        <tr>
            <td><b>4. Net Income After Tax</b></td>
            <td><b>NPR <?php echo number_format($net_income, 2); ?></b></td>
        </tr>
    </table>
<?php endif; ?>