<?php
// Function to add 'if' at the front (unless it already starts with 'if')
function addIf($str) {
    
    // Check if string already starts with 'if'
    if (substr($str, 0, 2) == "if") {
        return $str;
    }
    
    // Otherwise, add 'if ' to the front
    return "if " . $str;
}

// Test cases with sample inputs
echo addIf("if else") . "<br>";
echo addIf("else") . "<br>";
echo addIf("if");
?>