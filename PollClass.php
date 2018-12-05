<?php
include("GroupClass.php");
class Poll {
    private $pollID = -16;
    private $groupID = -16;
    private $restaurantName = "";
    
    public static function createNewPoll($groupID, $restaurantName) {
        
        $newPoll = new Poll();
        $newPoll->groupID=$groupID;
        $newPoll->restaurantName=$restaurantName;
        
        $newPoll->pollID = create_poll($groupID, $restaurantName);
        return $newPoll;
    }
    public static function retrievePoll($pollID) {
        
        $newPoll = new Poll();
        $newPoll->pollID = $pollID;
        
        $details = get_poll_details_from_id($pollID);
        $newPoll->groupID = $details["groupID"];
        $newPoll->restaurantName = $details["restaurantName"];
        return $newPoll;
    }
    public function restaurant() {
        return $this->restaurantName;
    }
    //  Returns true if poll is open, false if it is closed
    public function isOpen() {
        return is_open($this->pollID);
    }
    //  Sets poll to open
    public function setOpen() {  
        set_poll_open($this->pollID);
    }

    public function groupName() {
        return get_group_name_from_id($this->groupID);
    }

    public function id() {
        return $this->pollID;
    }
    
    //  Sets poll to closed
    public function setClosed() {    
        set_poll_closed($this->pollID);
    }
    public function majorityVoted() {
        $yes_votes = count(get_yes_votes_for_poll($this->pollID));
        $no_votes = count(get_no_votes_for_poll($this->pollID));
        $total_votes = $yes_votes + $no_votes;
        if ($total_votes > (count(get_users_from_group($groupID)) / 2)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    // returns array of userNames of users who voted yes
    public function userNamesVotedYes() {
        return get_user_names_voted_yes($this->pollID);
    }
    // returns array of userNames of users who voted no
    public function userNamesVotedNo() {
        return get_user_names_voted_no($this->pollID);
    }
    // returns array of userNames of users who haven't voted
    public function userNamesNotVoted() {
        return get_user_names_not_voted($this->pollID);
    }
    // return ID of group associated with this poll
    public function group() {
        return $this->groupID;
    }
    public function getResult() {
        $yes_votes = count(get_yes_votes_for_poll($this->pollID));
        $no_votes = count(get_no_votes_for_poll($this->pollID));
        if ($yes_votes >= $no_votes) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getResultString() {
        $yes_votes = count(get_yes_votes_for_poll($this->pollID));
        $no_votes = count(get_no_votes_for_poll($this->pollID));
        if ($yes_votes >= $no_votes) {
            return "Yes";
        } else {
            return "No";
        }
    }
    public function vote($userID, $value) {
        cast_vote($this->pollID, $userID, $value);
    }
    
    //  return a list of user ids of the users that have voted
    public function usersVotedList() 
    {
        return get_users_voted_in_poll($this->pollID);
    }
    
}
?>