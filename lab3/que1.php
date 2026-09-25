<?php
// 1. Interface Vehicle
interface Vehicle {
    public function startEngine();
    public function stopEngine();
}

// 2. Parent Class Car implementing Vehicle interface
class Car implements Vehicle {
    // Encapsulation: private properties
    private $make;
    private $model;
    private $year;

    // Constructor
    public function __construct($make, $model, $year) {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }

    // Getters and Setters
    public function getMake() { return $this->make; }
    public function setMake($make) { $this->make = $make; }

    public function getModel() { return $this->model; }
    public function setModel($model) { $this->model = $model; }

    public function getYear() { return $this->year; }
    public function setYear($year) { $this->year = $year; }

    // Methods
    public function start() {
        echo "Car started.<br>";
    }

    public function displayInfo() {
        echo "Make: {$this->make}, Model: {$this->model}, Year: {$this->year}<br>";
    }

    public function getDescription() {
        return "This is a standard car.";
    }

    // Interface methods
    public function startEngine() { echo "Engine started.<br>"; }
    public function stopEngine() { echo "Engine stopped.<br>"; }
}

// 3. Child Class ElectricCar extending Car
class ElectricCar extends Car {
    private $batteryCapacity;

    public function __construct($make, $model, $year, $batteryCapacity) {
        parent::__construct($make, $model, $year);
        $this->batteryCapacity = $batteryCapacity;
    }

    public function charge() {
        echo "Charging battery... Capacity: {$this->batteryCapacity} kWh<br>";
    }

    // Overriding getDescription method
    public function getDescription() {
        return "This is an electric car with a {$this->batteryCapacity} kWh battery.";
    }
}

// --- Testing the Classes ---
$myCar = new Car("Toyota", "Corolla", 2020);
$myCar->start();
$myCar->displayInfo();
$myCar->startEngine();

echo "<br>";

$myEV = new ElectricCar("Tesla", "Model 3", 2023, 75);
$myEV->displayInfo();
$myEV->charge();
echo $myEV->getDescription() . "<br>";
?>