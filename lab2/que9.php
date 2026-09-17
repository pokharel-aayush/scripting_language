<?php
// Function to check if a number is divisible by 5
function isDivisibleBy5($num) {
    
    // Returns true if remainder is 0, otherwise false
    return $num % 5 === 0;
}

// Test with 25 (divisible by 5)
var_dump(isDivisibleBy5(25));
echo "<br>";

// Test with 12 (not divisible by 5)
var_dump(isDivisibleBy5(12));
?>