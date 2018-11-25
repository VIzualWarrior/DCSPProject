
<?php
include("class_definitions.php");
class Group{
    private $groupID = -16; 
	private $groupName = "";
		
	public static function createNewGroup($groupName) {
		$newGroup = new Group();
		$newGroup->groupName = $groupName;
		$newGroup->groupID = create_group($groupName);
		return $newGroup;
	}
	public static function retrieveGroup($groupID) {
		
		$newGroup = new Group();
		$newGroup->groupID = $groupID;
		$details = get_group_name_from_id($groupID);
		$newGroup->groupName = $details["groupName"];
		return $newGroup;
	}
	public static function retrieveGroupByName($groupName) {
		
		$newGroup = new Group();
		$id = get_id_from_group_name($groupName);
		$newGroup->groupName = $groupName;
		$newGroup->groupID = $id;
		return $newGroup;
	}
	
	//	Returns a list of userIDs for users in the group.
    public function getUsers() {
    	return get_users_from_group($this->groupID);
	}
	//	Get polls for group
	public function getPolls() {
		return get_polls_for_group($this->groupID);
	}
	// get name of group
	public function name() {
		return $this->groupName;
	}
	//	add user to group by userID
	public function addUser($userID) {
        add_user_to_group(userID, $this->groupID);
    }
	//	kick user from group by userID
    public function kickUser($userID) {
        remove_user_from_group($userID, $this->groupID);
	}
	
	public function id() {
		return $this->groupID;
	}
}
?>