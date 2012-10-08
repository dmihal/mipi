<?php
/**
 * 
 */
class Shout {
	
	public $message;
	private $uid;
	
	function __construct($message,$userid) {
		$this->message = $message;
		$this->uid = $userid;
	}
	
	/**
	 * Return the memper who shouted
	 *
	 * @return Member
	 * @author  
	 */
	function getUser() {
		return Member::getMember($this->uid);
	}
	
	/**
     * Return array of last 10 shouts
     *
     * @return void
     * @author  
     */
    static function getShout($id) {
        $shouts = self::getShoutsFromQuery("SELECT  `user` , `message` FROM  `shouts` 
            WHERE `ID`=$id;");
        return $shouts[0];
    }
	/**
	 * Return array of last 10 shouts
	 *
	 * @return void
	 * @author  
	 */
	static function getLastTen() {
		return self::getShoutsFromQuery("SELECT  `user` , `message` FROM  `shouts` 
			ORDER BY  `date` ASC LIMIT 0 , 15");
	}
	/**
	 * Returns an array of shouts from SQL query
	 *
	 * @return void
	 * @author  
	 */
	static function getShoutsFromQuery($query) {
		$query = new Query($query);
		if ($query->numRows >= 1) {
			$array = array();
			while($row = $query->nextRow())
			{
				$shout = new self($row['message'],$row['user']);
				
				$array[] = $shout;
				unset($shout);
			}
			return $array;
		} else {
			throw new Exception();
		}
	}
    static function newShout($message,$user=NULL){
        $user = (is_null($user) ? getUser()->id : $user->id);
        $message = mysql_escape_string($message);
        $id = Query::insert("INSERT INTO `shouts` (`user` ,`message`)VALUES ('$user', '$message');");
        return self::getShout($id);
    }
	
}

?>