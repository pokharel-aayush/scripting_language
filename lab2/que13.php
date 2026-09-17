<?php
// Function to return value at a given index of an array
function getValueByIndex($arr, $index) {
    
    // Check if the index exists in the array
    if (isset($arr[$index])) {
        return $arr[$index];
    }
    
    // If not, return an error message
    return "Index out of bounds";
}

// Create a sample array
$myArray = array("Red", "Green", "Blue");

// Test with index 1
echo "Value at index 1: " . getValueByIndex($myArray, 1);
?>