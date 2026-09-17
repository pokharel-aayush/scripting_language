<?php
// Function to convert minutes to seconds
function convertToSeconds($minutes) {
    // 1 minute = 60 seconds
    return $minutes * 60;
}

// Sample value in minutes
$minutes = 5;

// Display converted value in seconds
echo "$minutes minutes is equal to " . convertToSeconds($minutes) . " seconds.";
?>