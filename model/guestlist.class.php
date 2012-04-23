<?php
/**
 * Class containing
 *
 * @package default
 * @author  
 */
class GuestList {
	
	public $event;
	public $guests;
	public $guestsByOwner; 
	private $pointer =0;
	
	public function __construct($event)
	{
		$this->event = $event;
		$query = new Query("SELECT * FROM `guests` WHERE `event`=$event ORDER BY `last`;");
		
		while ($row = $query->nextRow()) {
			$guest = new Person($row['first'],$row['last'],$row['ID']);
			$this->guests[] = array("guest"=>$guest, "owner"=>$row['owner']);
			$this->guestsByOwner[$row['owner']][$row['sex']][$row['order']] = $guest;
		}
		
	}
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author  
	 */
	function updateUserList(Member $user, $males, $females) {
		foreach ($males as $order => $person) {
			$this->updateUser($user, $order, $person, 'MALE');
		}
		foreach ($females as $order => $person) {
			$this->updateUser($user, $order, $person, 'FEMALE');
		}
	}
	private function updateUser(Member $user,$order,Person $person,$sex)
	{
		$count = new Query("SELECT count(*) as c FROM `guests` WHERE owner=$user->id AND `order`=$order AND `sex`='$sex'");
		if ($count->getField('c')>=1) {
			mysql_query("UPDATE `guests` SET `first` = '$person->first', `last`='$person->last' WHERE `owner`=$user->id AND `order`=$order AND `sex`='$sex'");
		} elseif($person->first !='' || $person->last!='') {
			mysql_query("INSERT INTO `guests` (`event`,`owner`,`order`,`first`,`last`,`sex`) VALUES ($this->event,$user->id,$order,'$person->first','$person->last','$sex')");
		}
		
	}
	/**
	 * Return member at current pointer
	 *
	 * @return Member
	 * @author  
	 */
	function getCurrentOwner() {
		return Member::getMember($this->guests[$this->pointer]['owner']);
	}
	/**
	 * Return guest at current pointer
	 *
	 * @return Person
	 * @author  
	 */
	function getCurrentGuest() {
		return array_key_exists($this->pointer, $this->guests) ? $this->guests[$this->pointer]['guest'] : NULL;
	}
	/**
	 * Advance Guest Pointer
	 *
	 * @return void
	 * @author  
	 */
	function advance() {
		$this->pointer++;
	}
	
} // END
?>