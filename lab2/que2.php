<?php
// Define constant value of PI
define("PI", 3.14159);

// Set the radius of the circle
$radius = 7; 

// Calculate area of circle (PI * r * r)
$area = PI * $radius * $radius;

// Display the area rounded to 2 decimal places
echo "The area of the circle with radius $radius is: " . round($area, 2);
?>