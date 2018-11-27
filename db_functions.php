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

function is_username_available($userName) {
    if (num_rows_matching("SELECT userName FROM Users WHERE userName = '$userName';") > 0) {
        return FALSE;
    }

    return TRUE;
}

// return the groupID of groups user is a member of
function get_groups_from_user($userID) {
    return get_list_from_column("SELECT groupID 
                        FROM GroupMembership 
                        WHERE userID = $userID;", "groupID");
}

// get names of all groups that a user is in
function get_group_names_from_user($userID) {
    return get_list_from_column("SELECT groupName
                        FROM Groups
                        WHERE groupID IN (SELECT groupID
                                            FROM GroupMembership
                                            WHERE userID = $userID);", "groupName");
}

// get only username from user id
function get_user_name_from_id($userID) {
    return get_single_specific_value("SELECT userName FROM Users WHERE userID = $userID;", "userName");
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
function get_user_names_from_group($groupID) {
    return get_list_from_column("SELECT U.userName 
                                    FROM Users U
                                    WHERE U.userID IN (SELECT GM.userID
                                                        FROM GroupMembership GM
                                                        WHERE GM.groupID = $groupID);", "userName");
}

function get_user_ids_from_group($groupID) {
    return get_list_from_column("SELECT userID
                                    FROM GroupMembership
                                    WHERE groupID = $groupID", "userID");
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
    return get_single_specific_value("SELECT groupID
                                            FROM Groups
                                            WHERE groupName = '$groupName'", "groupID");

}

// join group
function add_user_to_group($userID, $groupID) {
    do_query("INSERT INTO GroupMembership (userID, groupID)
                VALUES ($userID, $groupID)");
}

// leave group
function remove_user_from_group($userID, $groupID) {
    delete_without_constraints("DELETE FROM GroupMembership 
                                    WHERE (userID, groupID) = ($userID, $groupID);");
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
    delete_without_constraints("DELETE FROM Restaurants 
                                    WHERE restaurantID = $restaurantID");
}

function edit_restaurant_details($restaurantID, $restaurantName, $cuisineType, $address, $hoursOpen, $menu) {
    do_query("UPDATE Restaurants 
                SET restaurantName = '$restaurantName', cuisineType = '$cuisineType', `address` = '$address', hoursOpen = '$hoursOpen', menu = '$menu'
                WHERE restaurantID = $restaurantID");
}

// returns a list of every restaurant
function get_restaurant_names() {
    return get_list_from_column("SELECT restaurantName
                                    FROM Restaurants;", "restaurantName");
}

// poll functions
function create_poll($groupID, $restaurantName) {
    return do_query_get_last_id("INSERT INTO Polls (groupID, restaurantName)
                        VALUES ('$groupID', '$restaurantName');");
}

function get_polls_for_group($groupID) {
    return get_list_from_column("SELECT pollID 
                        FROM Polls 
                        WHERE groupID = $groupID;", "pollID");
}

// return all polls associated with user
function get_polls_for_user($userID) {
    return get_list_from_column("SELECT P.pollID
                                    FROM Polls P
                                    WHERE P.groupID IN (SELECT G.groupID
                                                            FROM GroupMembership G
                                                            WHERE G.userID = $userID)", "pollID");
}

// return only currently open polls for the user
function get_open_polls_for_user($userID) {
    return get_list_from_column("SELECT P.pollID
                                    FROM Polls P
                                    WHERE P.isOpen = 1 AND P.groupID IN (SELECT G.groupID
                                                                            FROM GroupMembership G
                                                                            WHERE G.userID = $userID)", "pollID");
}

// set specified poll to closed
function set_poll_open($pollID) {
    do_query("UPDATE Polls 
                SET isOpen = 1 
                WHERE pollID = $pollID");
}

// set specified poll to open
function set_poll_closed($pollID) {
    do_query("UPDATE Polls 
                SET isOpen = 0 
                WHERE pollID = $pollID");
}

// check if poll is open or closed
function is_open($pollID) {
    return get_array("SELECT isOpen
                        FROM Polls
                        WHERE pollID = $pollID");
}

// get all poll details
function get_poll_details_from_id($pollID) {
    return get_array("SELECT * FROM Polls WHERE pollID = $pollID;")[0];
}

// returns every yes vote for specified poll
function get_yes_votes_for_poll($pollID) {
    return get_list_from_column("SELECT voteID 
                                    FROM Votes 
                                    WHERE pollOptionID = $pollOptionID AND
                                    `value` = 1;", "voteID");
}

// returns every no vote for specified poll
function get_no_votes_for_poll($pollID) {
    return get_list_from_column("SELECT voteID 
                                    FROM Votes 
                                    WHERE pollOptionID = $pollOptionID AND
                                    `value` = 0;", "voteID");
}

// returns list of users who voted yes 
function get_user_ids_voted_yes($pollID) {
    return get_list_from_column("SELECT userID
                                    FROM Votes
                                    WHERE pollID = $pollID AND
                                    `value` = 1;", "userID");
}

// returns list of users who voted no
function get_user_ids_voted_no($pollID) {
    return get_list_from_column("SELECT userID
                                    FROM Votes
                                    WHERE pollID = $pollID AND
                                    `value` = 0;", "userID");
}

// get list of users who have not yet voted
function get_user_ids_not_voted($pollID) {
    return get_list_from_column("SELECT GM.userID
                                    FROM GroupMembership GM, Polls P
                                    WHERE P.pollID = $pollID AND
                                    P.groupID = GM.groupID AND
                                    GM.userID NOT IN (SELECT V.userID
                                                        FROM Votes V)", "userID");
}

// returns list of users who voted yes 
function get_user_names_voted_yes($pollID) {
    return get_list_from_column("SELECT U.userName
                                    FROM Votes V, Users U
                                    WHERE V.pollID = $pollID AND
                                    V.value = 1 AND
                                    V.userID = U.userID;", "userName");
}

// returns list of users who voted no
function get_user_names_voted_no($pollID) {
    return get_list_from_column("SELECT U.userName
                                    FROM Votes V, Users U
                                    WHERE V.pollID = $pollID AND
                                    V.value = 0 AND
                                    V.userID = U.userID;", "userName");
}

// get list of users who have not yet voted
function get_user_names_not_voted($pollID) {
    return get_list_from_column("SELECT U.userName
                                    FROM Users U
                                    WHERE U.userID IN (SELECT GM.userID
                                                            FROM GroupMembership GM, Polls P
                                                            WHERE P.pollID = $pollID AND
                                                            P.groupID = GM.groupID AND
                                                            GM.userID NOT IN (SELECT V.userID
                                                                                FROM Votes V))", "userName");
}


// casts a vote for the poll
function cast_vote($pollID, $userID, $value) {
    return do_query("INSERT INTO Votes (`pollID`, `userID`, `value`)
                    VALUES ($pollID, $userID, $value);");
}

// get list of users who have voted
function get_users_voted_in_poll($pollID) {
    return get_list_from_column("SELECT userID
                                    FROM Votes
                                    WHERE pollID = $pollID;", "userID");
}



?>