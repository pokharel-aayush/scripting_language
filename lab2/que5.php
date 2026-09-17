<?php
// Function to calculate area of a triangle
function triangleArea($base, $height) {
    // Area = 0.5 * base * height
    return 0.5 * $base * $height;
}

// Sample base and height values
$base = 10;
$height = 8;

// Display the calculated area
echo "The area of the triangle is: " . triangleArea($base, $height);
?>