<?php
// Function to return sum, or triple the sum if both numbers are equal
function sumOrTriple($num1, $num2) {
    
    // If both numbers are the same, return triple their sum
    if ($num1 == $num2) {
        return ($num1 + $num2) * 3;
    }
    
    // Otherwise return the normal sum
    return $num1 + $num2;
}

// Test cases with sample inputs
echo "Sum of 5 and 10: " . sumOrTriple(5, 10) . "<br>";
echo "Sum of 6 and 6: " . sumOrTriple(6, 6);
?>