<?php
class Product {
    public $description;
    public $quantity;
    public $price;

    // Constructor with type validation
    public function __construct($description, $quantity, $price) {
        if (!is_string($description)) {
            echo "Error: Description must be a string.<br>";
        } elseif (!is_numeric($quantity) || !is_numeric($price)) {
            echo "Error: Quantity and Price must be numbers.<br>";
        } else {
            $this->description = $description;
            $this->quantity = $quantity;
            $this->price = $price;
        }
    }

    // Setters and Getters
    public function setDescription($description) { $this->description = $description; }
    public function getDescription() { return $this->description; }

    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function getQuantity() { return $this->quantity; }

    public function setPrice($price) { $this->price = $price; }
    public function getPrice() { return $this->price; }

    // Calculate total price
    public function calculatePrice() {
        return $this->quantity * $this->price;
    }
}

// Create object
$product = new Product("Laptop", 2, 45000);

// Print properties
echo "Description: " . $product->getDescription() . "<br>";
echo "Quantity: " . $product->getQuantity() . "<br>";
echo "Price: " . $product->getPrice() . "<br>";
echo "Total Price: " . $product->calculatePrice() . "<br>";
?>