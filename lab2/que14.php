<?php
// Function to calculate number of cars needed (5 people per car)
function carsNeeded($n) {
    
    // Divide total people by 5 and round up
    return ceil($n / 5);
}

// Test with sample number of people
$people = 11;
echo "For $people people, cars needed: " . carsNeeded($people);
?>