<?php
// Function to get absolute difference from 51
function diffFrom51($n) {
    
    // Calculate absolute difference
    $diff = abs($n - 51);
    
    // If number is greater than 51, return triple the difference
    if ($n > 51) {
        return $diff * 3;
    }
    
    // Otherwise return the normal difference
    return $diff;
}

// Test cases with sample inputs
echo "Difference for 60: " . diffFrom51(60) . "<br>";
echo "Difference for 40: " . diffFrom51(40);
?>