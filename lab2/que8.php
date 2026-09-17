<?php
// Function to compare lengths of two strings
function compareStringLength($str1, $str2) {
    
    // If both strings have same length, return true
    if (strlen($str1) === strlen($str2)) {
        return true;
    }
    
    // Otherwise return false
    return false;
}

// Test with equal length strings
var_dump(compareStringLength("Hello", "World"));
echo "<br>";

// Test with different length strings
var_dump(compareStringLength("PHP", "Lab"));
?>