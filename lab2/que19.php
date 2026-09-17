<?php
// Function to add last character at front and back
function addLastChar($str) {
    
    // If string is empty, return it unchanged
    if (strlen($str) < 1) {
        return $str;
    }
    
    // Get the last character
    $lastChar = substr($str, -1);
    
    // Return last char + original string + last char
    return $lastChar . $str . $lastChar;
}

// Test cases with sample inputs
echo addLastChar("Red") . "<br>";
echo addLastChar("Green") . "<br>";
echo addLastChar("1");
?>