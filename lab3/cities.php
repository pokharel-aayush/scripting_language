<?php
// Get country from the AJAX request
$country = isset($_GET['country']) ? $_GET['country'] : '';

// Define cities for each country
$cities = [];

if ($country == "Nepal") {
    $cities = ["Kathmandu", "Pokhara", "Lalitpur", "Biratnagar"];
} elseif ($country == "USA") {
    $cities = ["New York", "Los Angeles", "Chicago", "Houston"];
} elseif ($country == "India") {
    $cities = ["Delhi", "Mumbai", "Bangalore", "Chennai"];
} else {
    $cities = [];
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($cities);
?>