<?php
// Function to find the index of a string in an array
function findStringIndex($arr, $str) {
    
    // Search for the string in the array
    $index = array_search($str, $arr);
    
    // If found, return the index
    if ($index !== false) {
        return $index;
    }
    
    // If not found, return an error message
    return "String not found in array";
}

// Create a sample array
$myArray = array("Apple", "Banana", "Cherry", "Date");

// Test with 'Cherry'
echo "Index of 'Cherry': " . findStringIndex($myArray, "Cherry");
?>