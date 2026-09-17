<?php
// Associative array with personal information
$info = [
    'Name' => 'Ram Bahadur', 
    'Address' => 'Lalitpur', 
    'Email' => 'info@ram.com', 
    'Phone' => 98454545, 
    'Website' => 'www.ram.com'
];

// --- TABLE: Display Info ---
echo "<table border='1' cellpadding='5' cellspacing='0'>";

// Loop through each key-value pair
foreach ($info as $key => $value) {
    // Display key as bold and value in the next cell
    echo "<tr><td><strong>$key</strong></td><td>$value</td></tr>";
}

// Close HTML table
echo "</table>";
?>