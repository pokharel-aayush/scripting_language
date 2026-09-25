<?php
class Student {
    // Properties
    public $name;
    public $surname;
    public $country;
    private $tuition;
    protected $indexNumber;

    // Getters for name and surname
    public function getName() { return $this->name; }
    public function getSurname() { return $this->surname; }

    // Public method
    public function helloWorld() {
        return "Hello World";
    }

    // Protected method
    protected function helloFamily() {
        return "Hello Family";
    }

    // Private method
    private function helloMe() {
        return "Hello me!";
    }

    // Private getter for tuition
    private function getTuition() {
        echo "Tuition: {$this->tuition}<br>";
    }
}

// Subclass PartTimeStudent
class PartTimeStudent extends Student {
    // Public method calling protected method from parent
    public function helloParent() {
        return $this->helloFamily();
    }
}

// Create objects
$student = new Student();
$student->name = "Ram";
$student->surname = "Bahadur";
$student->country = "Nepal";

$ptStudent = new PartTimeStudent();
$ptStudent->name = "Sita";
$ptStudent->surname = "Kumari";

// Call accessible methods
echo "Student Name: " . $student->getName() . " " . $student->getSurname() . "<br>";
echo "Student: " . $student->helloWorld() . "<br><br>";

echo "Part-Time Student Name: " . $ptStudent->getName() . " " . $ptStudent->getSurname() . "<br>";
echo "Part-Time Student: " . $ptStudent->helloWorld() . "<br>";
echo "Part-Time Student: " . $ptStudent->helloParent() . "<br>";
?>