<?php
    require_once("log_in.php");
    requre_once("wrappers.php");
// user and group functions
    function create_user($username, $firstName, $lastName, $email, $password, $isAdmin, $isLoggedIn) {
        do_query("INSERT INTO Users (username, firstName, lastName, email, `password`, isAdmin, isLoggedIn)
                    VALUES ($username, $firstName, $lastName, $email, $password, $isAdmin, $isLoggedIn) ");
        return get_array("SELECT LAST_INSERT_ID()
                            FROM Users");
    }
    function get_users_from_group($groupID) {
        return get_array("SELECT userID 
                            FROM GroupMembership 
                            WHERE groupID = $groupID");
    }
    // return the groupID of groups user is a member of
    function get_groups_from_user($userID) {
        return get_array("SELECT groupID 
                            FROM GroupMembership 
                            WHERE userID = $userID");
    }
    // remove a user from a group
    function remove_user_from_group($userID, $groupID) {
        do_query("DELETE FROM GroupMembership 
                    WHERE (userID, groupID) = ($userID, $groupID) ");
    }
    // return all attributes of a user with given id
    function get_user_details_from_id($userID) {
        return get_array("SELECT * 
                            FROM Users 
                            WHERE userID = $userID");
    }
    function is_admin($userID) {
        return get_array("SELECT isAdmin
                            FROM Users
                            WHERE userID = $userID");
    }
    function is_logged_in($userID) {
        return get_array("SELECT isLoggedIn
                            FROM Users
                            WHERE userID = $userID");
    }
    function log_out($userID) {
        do_query("UPDATE Users
                    SET isLoggedIn = 0
                    WHERE userID = $userID");
    }
    function log_in($userID) {
        do_query("UPDATE Users
                    SET isLoggedIn = 1
                    WHERE userID = $userID");
    }
    // authenticate user
    function authenticate_user($userName, $token) {
        $does_user_exist = check_user_record($userName);
        if($does_user_exist) {
            $is_password_correct = check_password($userName, $token);
        }
        return $is_password_correct;
    }
    // join group
    function join_group($userID, $groupID) {
        do_query("INSERT INTO GroupMembership (userID, groupID)
                    VALUES ($userID, $groupID)");
    }
// restaurant functions
    function add_restaurant($restaurantName, $cuisineType, $address, $hoursOpen, $menu, $userID) {
        if (is_admin($userID)) {
            do_query("INSERT INTO Restaurants (restaurantName, cuisineType, `address`, hoursOpen, menu)
                        VALUES ($restaurantName, $cuisineType, $address, $hoursOpen, $menu) ");
            return get_array("SELECT LAST_INSERT_ID()
                                FROM Restaurants");
        }
    }
    function get_restaurant_details($restaurantID) {
        return get_array("SELECT * 
                            FROM Restaurants 
                            WHERE restaurantID = $restaurantID");
    }
    // return the restaurantID only from search pattern
    function get_restaurant_id_from_pattern($pattern) {
        return get_array("SELECT restaurantID 
                            FROM Restaurants 
                            WHERE restaurantName LIKE %$pattern%");
    }
    // return array of restaurants with details from search pattern
    function get_restaurant_details_from_pattern($pattern) {
        return get_array("SELECT * 
                            FROM Restaurants
                            WHERE restaurantName LIKE %$pattern%");
    }
    // deletes restaurant from the database
    function delete_restaurant($restaurantID) {
        do_query("DELETE FROM Restaurants 
                WHERE restaurantID = $restaurantID");
    }
    function edit_restaurant_details($restaurantID, $restaurantName, $cuisineType, $address, $hoursOpen, $menu) {
        do_query("UPDATE Restaurants 
                    SET restaurantName = $restaurantName, cuisineType = $cuisineType, `address` = $address, hoursOpen = $hoursOpen, menu = $menu
                    WHERE restaurantID = $restaurantID");
    }
// poll functions
    function get_polls_for_group($groupID) {
        return get_array("SELECT pollID 
                            FROM Polls 
                            WHERE groupID = $groupID");
    }
    // set specified poll to closed
    function set_poll_open($groupID) {
        do_query("UPDATE Polls 
                    SET isOpen = 1 
                    WHERE groupID = $groupID");
    }
    // set specified poll to open
    function set_poll_closed($groupID) {
        do_query("UPDATE Polls 
                    SET isOpen = 0 
                    WHERE groupID = $groupID");
    }
    // get all options to be voted on in poll
    function get_options_from_poll($pollID) {
        return get_array("SELECT pollOptionId 
                            FROM PollOptions 
                            WHERE pollID = $pollID");
    }
    // returns every vote for specified option
    function get_votes_for_option($pollOptionID) {
        return get_array("SELECT voteID 
                            FROM Votes 
                            WHERE pollOptionID = $pollOptionID");
    }
    // returns all attributes for specified option
    function get_details_for_option($pollOptionID) {
        return get_array("SELECT * 
                            FROM PollOptions 
                            WHERE pollOptionID = $pollOptionID");
    }
    // casts a vote for a specified poll option, return voteID
    function cast_vote($pollOptionID, $userID) {
        do_query("INSERT INTO Vote (`pollOptionID`, `userID`)
                    VALUES ($pollOptionID, $userID)");
        return get_array("SELECT LAST_INSERT_ID()
                            FROM Vote");
    }
?>