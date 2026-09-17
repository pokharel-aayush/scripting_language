<?php
// Function to calculate area of triangle or parallelogram
function calculateShapeArea($base, $height, $shape) {
    
    // Convert shape to lowercase for easy comparison
    $shape = strtolower($shape);
    
    // If shape is triangle, use 0.5 * base * height
    if ($shape == "triangle") {
        return 0.5 * $base * $height;
    } 
    // If shape is parallelogram, use base * height
    elseif ($shape == "parallelogram") {
        return $base * $height;
    } 
    // If shape is neither, return error message
    else {
        return "Invalid shape";
    }
}

// Test with triangle
echo "Area of Triangle: " . calculateShapeArea(10, 5, "triangle") . "<br>";

// Test with parallelogram
echo "Area of Parallelogram: " . calculateShapeArea(10, 5, "parallelogram");
?>