<?php
include("db_functions.php");
class Poll {
    private $pollID= -16;
    private $groupID= -16;
    
    public static function createNewPoll($groupID) {
        
        $newPoll = new Poll();
        $newPoll->groupID=$groupID;
        
        $newPoll->pollID = create_poll($pollID,$groupID);
        return $newPoll;
    }
    public static function retrievePoll($pollID) {
        
        $newPoll = new Poll();
        $newPoll->pollID = $pollID;
        
        $details = get_poll_details_from_id($pollID);
        $newPoll->groupID = $details["groupID"];
        return $newPoll;
    }
    //  Returns true if poll is open, false if it is closed
    public function isOpen()
    {
        return is_open($this->pollID);
    }
    //  Sets poll to open
    public function setOpen()
    {  
        set_poll_open($this->groupID);
    }
    
    //  Sets poll to closed
    public function setClosed()
    {    
        set_poll_closed($this->groupID);
    }
    //  Gets results of poll. returns an associative array, with the structure of
    //  result["restaurantID"] = 32, result["voteCount"] = 2
    public function getResults()
    {
        return get_poll_results($this->pollID);
    }
    //  Creates a vote for a poll option by specified user and stores in database. 
    public function vote($userID, $pollOptionID)
    {
        cast_vote($this->pollOptionID, $userID);
    }
    
    //  Retrieves which users have voted.
    public function usersVotedList() 
    {
        get_users_voted($this->pollID);
    }
    
}
?>