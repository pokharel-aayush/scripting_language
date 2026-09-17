<?php
// Function to uppercase last 3 characters (or whole string if shorter)
function uppercaseLastThree($str) {
    
    // If string length is less than 3, uppercase entire string
    if (strlen($str) < 3) {
        return strtoupper($str);
    }
    
    // Split string: front part and last three characters
    $front = substr($str, 0, -3);
    $lastThree = substr($str, -3);
    
    // Uppercase last three and join back
    return $front . strtoupper($lastThree);
}

// Test cases with sample inputs
echo uppercaseLastThree("Nepal") . "<br>";
echo uppercaseLastThree("Npl") . "<br>";
echo uppercaseLastThree("Bca") . "<br>";
echo uppercaseLastThree("Bachelor");
?>