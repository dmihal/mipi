<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class Officer {
	
	public $id,$name,$title,$subtitle,$memberID;
	
	public function __construct($name)
	{
		$this->name = $name;
		
		$q = new Query("SELECT * FROM officers WHERE `name`='$name'");
		if($q->numRows!=1)
		{
			throw new Exception("Officer query failure", 1);
		} else {
			$this->id		= $q->getField("ID");
			$this->memberID	= $q->getField("member");
			$this->title	= $q->getField("title");
			$this->subtitle	= $q->getField("subtitle");
		}
	}
	/**
	 * Get the Member object of the officer
	 *
	 * @return Member 
	 */
	public function getMember()
	{
		return $this->memberID ? Member::getMember($this->memberID) : NULL;
	}
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author  
	 */
	function getAnnouncements()
	{
		return Announcement::getAnnouncementsFromQuery("SELECT * FROM `announcements` WHERE `officer`=$this->id ORDER BY `date`");
	}
	static function getOfficerLists($elected=true)
	{
		$elected = $elected ? 'true' : 'false';
		$officers = array();
		$q = new Query("SELECT name,title FROM officers WHERE `elected` like '$elected' ORDER BY `sort`");
		while($officer = $q->nextRow())
		{
			$officers[$officer['name']] = $officer['title'];
		}
		return $officers;
	}
} // END
?>