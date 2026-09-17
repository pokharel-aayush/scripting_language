<?php
// Multidimensional array with student data
$students = [
    ["Rapeth", 25, 56, 89, 57, 64, 98],
    ["Hari",   55, 68, 95, 76, 49, 81],
    ["Shyam",  65, 47, 05, 76, 99, 81],
    ["Rita",   10, 58, 89, 56, 68, 98],
    ["Gita",   45, 68, 95, 76, 99, 81],
    ["Sita",   34, 56, 89, 57, 94, 98],
    ["Sita",   34, 56, 89, 57, 94, 98],
    ["Sita",   34, 56, 89, 57, 94, 98]
];

// --- TABLE 1: Mark Ledger ---
echo "<h3>Mark Ledger</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; font-family: Arial;'>";
echo "<tr style='background-color: #999999;'>
        <th>SV</th><th>Name</th><th>Roll</th><th>Web Tech II</th>
        <th>DBMS</th><th>Economics</th><th>DSA</th><th>Account</th>
        <th>Total</th><th>Result</th>
      </tr>";

$sv = 1;
foreach ($students as $student) {
    $name = $student[0];
    $roll = $student[1];
    $sub1 = $student[2];
    $sub2 = $student[3];
    $sub3 = $student[4];
    $sub4 = $student[5];
    $sub5 = $student[6];
    
    $total = $sub1 + $sub2 + $sub3 + $sub4 + $sub5;
    
    // Fail if any subject is less than 40
    $isFail = ($sub1 < 40 || $sub2 < 40 || $sub3 < 40 || $sub4 < 40 || $sub5 < 40);
    $result = $isFail ? "fail" : "pass";
    
    // Set background color based on result
    $bgColor = $isFail ? "#FF0000" : "#00FF00";

    echo "<tr style='background-color: $bgColor;'>
            <td>$sv</td><td>$name</td><td>$roll</td><td>$sub1</td>
            <td>$sub2</td><td>$sub3</td><td>$sub4</td><td>$sub5</td>
            <td>$total</td><td>$result</td>
          </tr>";
    $sv++;
}
echo "</table>";
?>