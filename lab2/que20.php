<?php
// Function to add first 3 characters to front and back
function addFirstThree($str) {
    
    // Extract the first 3 characters (or less if string is shorter)
    $front = substr($str, 0, 3);
    
    // Return front part + original string + front part
    return $front . $str . $front;
}

// Test cases with sample inputs
echo addFirstThree("Python") . "<br>";
echo addFirstThree("JS") . "<br>";
echo addFirstThree("Code");
?>