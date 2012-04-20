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
			$this->guestsByOwner[$row['owner']][$row['sex']][] = $guest;
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
		$count = new Query("SELECT count(*) as c FROM `guests` WHERE owner=$user->id AND `order`=$order AND `sex`=$sex");
		if ($count->getField('c')>=1) {
			mysql_query("UPDATE `guests` SET `first` = '$person->first', `last`='$person->last' WHERE `owner`=$user->id AND `order`=$order AND `sex`='$sex'");
		} else {
			mysql_query("INSERT INTO `guests` (event,owner,order,first,last) VALUES ($this->event,$user->id,$order,$person->first,$person->last)");
		}
		
	}
	/**
	 * Return member at current pointer
	 *
	 * @return Member
	 * @author  
	 */
	function getCurrentOwner() {
		return $this->guests[$this->pointer]['owner'];
	}
	/**
	 * Return guest at current pointer
	 *
	 * @return Person
	 * @author  
	 */
	function getCurrentGuest() {
		return $this->guests[$this->pointer]['guest'];
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