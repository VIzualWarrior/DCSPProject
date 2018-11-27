
<?php
include("class_definitions.php");
class Group{
	private $groupID = -16; 
	private $groupName = "";
		
	public static function createNewGroup($groupName) {
		$newGroup = new Group();
		$newGroup->groupName = $groupName;
		$newGroup->groupID = $groupID;
		
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
		
		return Group::retrieveGroup(get_id_from_group_name($groupName));
		
	}
	
	//	Returns a list of userNames for users in this group
    public function getUserNames() {
    	return get_user_names_from_group($this->groupID);
	}
	// Returns an array of userIDs for users in this group
	public function getUserIDs() {
		return get_user_ids_from_group($this->groupID);
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
        add_user_to_group($userID, $this->groupID);
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