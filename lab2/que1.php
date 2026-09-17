<?php
// Use <pre> tag so newlines \n display correctly in browser
echo "<pre>";

// Declare variables of different data types
$intVar    = 25;
$floatVar  = 12.75;
$stringVar = "BCA Student";
$boolVar   = true;
$arrayVar  = array("PHP", "MySQL", "HTML");
$nullVar   = null;

// a. Output using echo and print
echo "Integer: $intVar\n";
echo "Float: $floatVar\n";
echo "String: $stringVar\n";
echo "Boolean: " . ($boolVar ? "true" : "false") . "\n";
print "Null Value: "; print_r($nullVar);
echo "\n";

// b. Display array contents using print_r and var_dump
print_r($arrayVar);
var_dump($arrayVar);

// c. Check and display data types
echo "Type of \$intVar: " . gettype($intVar) . "\n";
var_dump(is_int($intVar));
var_dump(is_array($arrayVar));

echo "</pre>";
?>