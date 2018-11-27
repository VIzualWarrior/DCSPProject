<?php
include("db_functions.php");
// factory class for creating or retrieving users
// things that aren't likely to change over time will
// be recorded as attributes in the class. Things that
// are more volatile will stay in the database.
class User {
    private $userID = -16;
    private $userName = "";
    private $firstName = "";
    private $lastName = "";
    private $email = "";
    private $password = "";
    private $isAdmin = false;
    // returns the user if created, otherwise FALSE. . . (i know that's not super cool to do)
    public static function createNewUser($userName, $firstName, $lastName, $email, $password, $isAdmin) {
        
        if (is_username_available($userName)) {
            $newUser = new User();
            $newUser->userName = $userName;
            $newUser->firstName = $firstName;
            $newUser->lastName = $lastName;
            $newUser->email = $email;
            $newUser->password = $password;
            $newUser->isAdmin = $isAdmin;
            $newUser->userID = create_user($userName, $firstName, $lastName, $email, $password, $isAdmin);
            return $newUser;
        } else {
            return FALSE;
        }
    }
    public static function retrieveUser($userID) {
        $newUser = new User();
        
        $newUser->userID = $userID;
        $details = get_user_details_from_id($userID);
        $newUser->userName = $details["userName"];
        $newUser->firstName = $details["firstName"];
        $newUser->lastName = $details["lastName"];
        $newUser->email = $details["email"];
        $newUser->password = $details["password"];
        $newUser->isAdmin = $details["isAdmin"];
        return $newUser;
    }
    public function getAllDetails() {
        return get_user_details_from_id($this->userID);
    }
    public function listGroups() {
        return get_groups_from_user($this->userID);
    }
    public function listAllPolls() {
        return get_polls_for_user($this->userID);
    }
    public function listOpenPolls() {
        return get_open_polls_for_user($this->userID);
    }
    public function isAdmin() {
        return $this->isAdmin;
    }
    public function authenticate($input_password) {
        if ($this->password == $input_password) {
            return true;
        }
        else {
            return false;
        }
    }
}
// although the design doc and the database function are made to return the restaurant ID, it may be more useful to return the
// restaurant object here. I'll leave it returning the object for now.
class Restaurant {
    private $restaurantID = -16;
    private $restaurantName = "";
    private $cuisineType = "";
    private $address = "";
    private $hoursOpen = "";
    private $menu = "";
    public static function createNewRestaurant($restaurantName, $cuisineType, $address, $hoursOpen, $menu, $userID) {
        $add_attempt = add_restaurant($restaurantName, $cuisineType, $address, $hoursOpen, $menu, $userID);
        if (!($add_attempt === false)) {
            $newRestaurant = new Restaurant();
            $newRestaurant->restaurantName = $restaurantName;
            $newRestaurant->cuisineType = $cuisineType;
            $newRestaurant->address = $address;
            $newRestaurant->hoursOpen = $hoursOpen;
            $newRestaurant->menu = $menu;
            return $newRestaurant;
        }
    }
    public static function retrieveRestaurant($restaurantID) {
        $newRestaurant = new User();
        
        $newRestaurant->userID = $userID;
        $details = get_restaurant_details_from_id($restaurantID);
        $newRestaurant->restaurantName = $details["restaurantName"];
        $newRestaurant->cuisineType = $details["cuisineType"];
        $newRestaurant->address = $details["address"];
        $newRestaurant->hoursOpen = $details["hoursOpen"];
        $newRestaurant->menu = $details["menu"];
        return $newRestaurant;
    }
    public function getAllDetails() {
        return get_restaurant_details_from_id($this->restaurantID);
    }
    public function editDetails($restaurantName, $cuisineType, $address, $hoursOpen, $menu) {
        edit_restaurant_details($this->restaurantID, $restaurantName, $cuisineType, $address, $hoursOpen, $menu);
    }
}
class Search {
    
    private $pattern;
    private $resultIDs = false;
    private $resultDetails = false;
    function __construct($pattern) {
        $this->pattern = $pattern;
    }
    // check if we haven't already gotten a result for this before running the query
    public function getIDs() {
    
        if ($this->resultIDs == false) {
            $this->resultIDs = get_restaurant_id_from_pattern($this->pattern);
        }
        return $this->resultIDs;
    }
    
    // same as above. this will return an array of arrays, where the first "layer" of arrays
    // will be a restaurant, and each element of each array will be the restaurant details
    public function getDetails() {
        if ($this->resultDetails == false) {
            $this->resultDetails = get_restaurant_details_from_pattern($this->pattern);
        }
        return $this->resultDetails;
    }
}
?>