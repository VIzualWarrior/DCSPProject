<?php
require_once("db_functions.php");
// factory class for creating or retrieving users
// things that aren't likely to change over time will
// be recorded as attributes in the class. Things that
// are more volitile will stay in the database.
class User {
    private $userID = 0;
    private $username = "";
    private $firstName = "";
    private $lastName = "";
    private $email = "";
    private $password = "";
    private $isAdmin = false;
    //private $isLoggedIn = false; considering removing, as this will change frequently
    function __construct() {
    }
    public static function createNewUser($username, $firstName, $lastName, $email, $password, $isAdmin, $isLoggedIn) {
        $newUser = new User();
        $newUser->username = $username;
        $newUser->firstName = $firstName;
        $newUser->lastName = $lastName;
        $newUser->email = $email;
        $newUser->password = $password;
        $newUser->isAdmin = $isAdmin;
        $newUser->isLoggedIn = $isLoggedIn;
        $newUser->userID = create_user($username, $firstName, $lastName, $email, $password, $isAdmin, $isLoggedIn);
        return $newUser;
    }
    public static function retrieveUser($userID) {
        $newUser = new User();
        
        $newUser->userID = $userID;
        $details = get_user_details_from_id($userID);
        $newUser->username = $details["username"];
        $newUser->firstName = $details["firstName"];
        $newUser->lastName = $details["lastName"];
        $newUser->email = $details["email"];
        $newUser->password = $details["password"];
        $newUser->isAdmin = $details["isAdmin"];
        $newUser->isLoggedIn  = $details["isLoggedIn"];
        return $newUser;
    }
    public function listGroups() {
        return get_groups_from_user($this->userID);
    }
    public function joinGroup($groupID) {
        join_group($this->userID, $groupID);
    }
    public function leaveGroup($groupID) {
        remove_user_from_group($this->userID, $groupID);
    }
    public function isAdmin() {
        return $this->isAdmin;
    }
    public function isLoggedIn() {
        return $this->isLoggedIn;
    }
    public function logOut() {
        $this->isLoggedIn = false;
        log_out($this->userID);
    }
    public function logIn() {
        $this->isLoggedIN = true;
        log_in($this->userID);
    }
}
?>