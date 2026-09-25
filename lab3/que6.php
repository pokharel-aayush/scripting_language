<?php
// Base Class User
class User {
    protected $name;
    protected $surname;
    protected $username;
    protected $is_admin = false;

    public function __construct($name, $surname, $username) {
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
    }

    public function isAdmin() {
        return $this->is_admin;
    }

    public function printFullName() {
        $fullname = $this->name . " " . $this->surname;
        if ($this->is_admin) {
            $fullname .= " (admin)";
        }
        return $fullname;
    }
}

// Child Class Customer
class Customer extends User {
    private $city;
    private $state;
    private $country;

    public function __construct($name, $surname, $username, $city, $state, $country) {
        parent::__construct($name, $surname, $username);
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
    }

    public function setCity($city) { $this->city = $city; }
    public function getCity() { return $this->city; }

    public function setState($state) { $this->state = $state; }
    public function getState() { return $this->state; }

    public function setCountry($country) { $this->country = $country; }
    public function getCountry() { return $this->country; }

    public function location() {
        return "{$this->city}, {$this->state}, {$this->country}";
    }
}

// Child Class AdminUser
class AdminUser extends User {
    public function __construct($name, $surname, $username) {
        parent::__construct($name, $surname, $username);
        $this->is_admin = true;
    }
}

// --- Testing ---
$user = new User("Ram", "Bahadur", "ram123");
$admin = new AdminUser("Sita", "Kumari", "sita_admin");
$customer = new Customer("Hari", "Shrestha", "hari_c", "Kathmandu", "Bagmati", "Nepal");

// Print User
echo "User: " . $user->printFullName() . " | is_admin: " . ($user->isAdmin() ? "true" : "false") . "<br>";

// Print Admin
echo "Admin: " . $admin->printFullName() . " | is_admin: " . ($admin->isAdmin() ? "true" : "false") . "<br>";

// Print Customer
echo "Customer: " . $customer->printFullName() . " | is_admin: " . ($customer->isAdmin() ? "true" : "false") . "<br>";
echo "Customer Location: " . $customer->location() . "<br>";
?>