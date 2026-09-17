<?php
// Function to convert age in years to days (assumes 365 days per year)
function ageToDays($ageInYears) {
    return $ageInYears * 365;
}

// Sample age in years
$age = 20;

// Display age in years
echo "Age in years: $age";
echo "<br>";

// Display age in days using the function
echo "Age in days: " . ageToDays($age);
?>