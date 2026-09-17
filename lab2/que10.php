<?php
// Recursive function to find length of a string
function recursiveStrLen($str) {
    
    // Base case: if string is empty, length is 0
    if ($str === "") {
        return 0;
    }
    
    // Recursive case: 1 + length of remaining string (after removing first char)
    return 1 + recursiveStrLen(substr($str, 1));
}

// Test with sample string
$testString = "BCA Student";
echo "The length of '$testString' is: " . recursiveStrLen($testString);
?>