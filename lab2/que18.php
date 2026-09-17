<?php
// Function to repeat first 2 characters 4 times
function repeatFrontTwo($str) {
    
    // If string length is less than 2, return original string
    if (strlen($str) < 2) {
        return $str;
    }
    
    // Extract the first 2 characters
    $front = substr($str, 0, 2);
    
    // Repeat the extracted characters 4 times
    return str_repeat($front, 4);
}

// Test cases with sample inputs
echo repeatFrontTwo("C Sharp") . "<br>";
echo repeatFrontTwo("JS") . "<br>";
echo repeatFrontTwo("a");
?>