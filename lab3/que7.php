<?php
// Interface
interface Shape {
    public function calculateArea();
}

// Circle Class
class Circle implements Shape {
    private $radius;

    public function __construct($radius) {
        $this->radius = $radius;
    }

    public function calculateArea() {
        return 3.14159 * $this->radius * $this->radius;
    }
}

// Square Class
class Square implements Shape {
    private $side;

    public function __construct($side) {
        $this->side = $side;
    }

    public function calculateArea() {
        return $this->side * $this->side;
    }
}

// --- Testing ---
$circle = new Circle(5);
$square = new Square(4);

echo "Area of Circle (radius 5): " . $circle->calculateArea() . "<br>";
echo "Area of Square (side 4): " . $square->calculateArea() . "<br>";
?>