<?php
// Function to find the largest among three numbers
function findLargest($a, $b, $c) {
    
    // Check if $a is the largest
    if ($a >= $b && $a >= $c) {
        return $a;
    } 
    // Check if $b is the largest
    elseif ($b >= $a && $b >= $c) {
        return $b;
    } 
    // Otherwise $c is the largest
    else {
        return $c;
    }
}

// Test with sample values
echo "The largest among 10, 25, and 15 is: " . findLargest(10, 25, 15);
?>