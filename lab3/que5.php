<?php
// Interface
interface HasInfo {
    public function getInfo();
}

// Address Class
class Address implements HasInfo {
    public $street;
    public $number;
    public $city;

    public function __construct($street, $number, $city) {
        $this->street = $street;
        $this->number = $number;
        $this->city = $city;
    }

    public function getInfo() {
        return "Address: street {$this->street}, number {$this->number}, city {$this->city}";
    }
}

// Phone Class
class Phone implements HasInfo {
    public $prefix;
    public $number;

    public function __construct($prefix, $number) {
        $this->prefix = $prefix;
        $this->number = $number;
    }

    public function getInfo() {
        return "Number: {$this->prefix} / {$this->number}";
    }
}

// User Class
class User implements HasInfo {
    public $name;
    public $surname;
    private $address;
    private $phone;

    public function __construct($name, $surname, Address $address, Phone $phone) {
        $this->name = $name;
        $this->surname = $surname;
        $this->address = $address;
        $this->phone = $phone;
    }

    public function getInfo() {
        return "User: {$this->name} {$this->surname} <br>" . 
               $this->address->getInfo() . "<br>" . 
               $this->phone->getInfo();
    }
}

// Create objects
$address = new Address("Main Street", "123", "Lalitpur");
$phone = new Phone("+977", "9845454545");
$user = new User("Aayush", "Pokharel", $address, $phone);

// Call method
echo $user->getInfo();
?>