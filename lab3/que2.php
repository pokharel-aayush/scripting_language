<?php
class Bicycle {
    // Public properties
    public $brand;
    public $model;
    public $year;
    public $description = "Used bicycle"; // Default value
    public $weight; // Stores weight in grams

    // Getter for info
    public function getInfo() {
        return "{$this->brand} {$this->model} ({$this->year})";
    }

    // Getter for weight (default: grams, if true: kilograms)
    public function getWeight($inKg = false) {
        if ($inKg) {
            return ($this->weight / 1000) . " kg";
        } else {
            return $this->weight . " g";
        }
    }

    // Setter for weight
    public function setWeight($weight) {
        $this->weight = $weight;
    }
}

// Create first object
$bike1 = new Bicycle();
$bike1->brand = "Trek";
$bike1->model = "FX 3";
$bike1->year = 2021;
$bike1->setWeight(12000);

// Create second object
$bike2 = new Bicycle();
$bike2->brand = "Giant";
$bike2->model = "Escape 3";
$bike2->year = 2022;
$bike2->setWeight(10500);

// Print info and weights
echo "Bike 1 Info: " . $bike1->getInfo() . "<br>";
echo "Bike 1 Weight: " . $bike1->getWeight() . " / " . $bike1->getWeight(true) . "<br><br>";

echo "Bike 2 Info: " . $bike2->getInfo() . "<br>";
echo "Bike 2 Weight: " . $bike2->getWeight() . " / " . $bike2->getWeight(true) . "<br>";
?>