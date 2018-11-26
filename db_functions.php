<?php
include("wrappers.php");
// long function names 2: rebirth
// user functions
function create_user($userName, $firstName, $lastName, $email, $password, $isAdmin) {
    return do_query_get_last_id("INSERT INTO Users (userName, firstName, lastName, email, `password`, isAdmin)
                                    VALUES ('$userName', '$firstName', '$lastName', '$email', '$password', $isAdmin);");
}
function edit_user_details($userID, $userName, $firstName, $lastName, $email, $password, $isAdmin) {
    do_query("UPDATE Users 
                SET userName = '$userName', firstName = '$firstName', lastName = '$lastName', email = '$email', `password` = '$password', isAdmin = $isAdmin
                WHERE userID = $userID");
}
// return the groupID of groups user is a member of
function get_groups_from_user($userID) {
    return get_array("SELECT groupID 
                        FROM GroupMembership 
                        WHERE userID = $userID");
}
// get get names of all groups that a user is in
function get_group_names_from_user($userID) {
    return get_array("SELECT groupName
                        FROM Groups
                        WHERE groupID IN (SELECT groupID
                                            FROM GroupMembership
                                            WHERE userID = $userID)");
}
// return all attributes of a user with given id
function get_user_details_from_id($userID) {
    return get_array("SELECT * 
                        FROM Users 
                        WHERE userID = $userID")[0];
}
function is_admin($userID) {
    return get_array("SELECT isAdmin
                        FROM Users
                        WHERE userID = $userID");
}
// delete user
function delete_user($userID) {
    do_query("DELETE FROM Users
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
// group functions
function get_users_from_group($groupID) {
    return get_array("SELECT userID 
                        FROM GroupMembership 
                        WHERE groupID = $groupID");
}
function create_group($groupName) {
    return do_query_get_last_id("INSERT INTO Groups (groupName)
                        VALUES ('$groupName');");
}
// get group name from groupID
function get_group_name_from_id($groupID) {
    $result = get_array("SELECT groupName
                        FROM Groups
                        WHERE groupID = $groupID");
					
	return $result[0];
}
// get groupID from groupName
function get_id_from_group_name($groupName) {
	$result = get_array("SELECT groupID
						FROM Groups
                        WHERE groupName = '$groupName'");
    
    return $result[0];
}
// join group
function add_user_to_group($userID, $groupID) {
    do_query("INSERT INTO GroupMembership (userID, groupID)
                VALUES ($userID, $groupID)");
}
// leave group
    function remove_user_from_group($userID, $groupID) {
    do_query("DELETE FROM GroupMembership 
                WHERE (userID, groupID) = ($userID, $groupID) ");
}
// restaurant functions
function add_restaurant($restaurantName, $cuisineType, $address, $hoursOpen, $menu, $userID) {
    if (is_admin($userID)) {
        return do_query_get_last_id("INSERT INTO Restaurants (restaurantName, cuisineType, `address`, hoursOpen, menu)
                            VALUES ('$restaurantName', '$cuisineType', '$address', '$hoursOpen', '$menu');");
    }
    else{
        return false;
    }
}
function get_restaurant_details_from_id($restaurantID) {
    return get_array("SELECT * 
                        FROM Restaurants 
                        WHERE restaurantID = $restaurantID");
}
// return the restaurantID only from search pattern
function get_restaurant_ids_from_pattern($pattern) {
    return get_array("SELECT * 
                        FROM Restaurants 
                        WHERE restaurantName LIKE '%$pattern%'");
}
// return array of restaurants with details from search pattern
// note, this will be an array of arrays, so you would need to iterate
// through the array, as in "for row in result echo row['element']
function get_restaurant_details_from_pattern($pattern) {
    return get_array("SELECT * 
                        FROM Restaurants
                        WHERE restaurantName LIKE '%$pattern%'");
}
// deletes restaurant from the database
function delete_restaurant($restaurantID) {
    do_query("DELETE FROM Restaurants 
            WHERE restaurantID = $restaurantID");
}
function edit_restaurant_details($restaurantID, $restaurantName, $cuisineType, $address, $hoursOpen, $menu) {
    do_query("UPDATE Restaurants 
                SET restaurantName = '$restaurantName', cuisineType = '$cuisineType', `address` = '$address', hoursOpen = '$hoursOpen', menu = '$menu'
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
// check if poll is open or closed
function is_open($pollID) {
    return get_array("SELECT isOpen
                        FROM Polls
                        WHERE pollID = $pollID");
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
                VALUES ($pollOptionID, $userID);");
    return do_query_get_last_id("INSERT INTO Vote (`pollOptionID`, `userID`)
                                    VALUES ($pollOptionID, $userID);");
}
// get list of users who have voted
function get_users_voted($pollID) {
    return get_array("SELECT V.userID
                        FROM Votes V, PollOptions PO, Polls, PL
                        WHERE V.pollOptionID = PO.pollOptionID AND
                        PO.pollID = PL.pollID AND PL.pollID = $pollID");
}
?>