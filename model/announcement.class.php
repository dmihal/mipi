<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class Announcement {
	
	public $title,$body;
	public $id,$officerID, $authorID;
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author  
	 */
	function getOfficer() {
	}
	/**
	 * undocumented function
	 *
	 * @return Member
	 */
	function getAuthor() {
		return Member::getMember($this->authorID);
	}
	
	/**
	 * Return array of announcements generated from SQL Query
	 * 
	 * @param $query string
	 * @return array(Announcement)
	 */
	static function getAnnouncementsFromQuery($q)
	{
		$query = new Query($q);
		if ($query->numRows >=1) {
			$announcements = array();
			while($row = $query->nextRow())
			{
				$announcement = new Announcement();
				$announcement->id		= $row['ID'];
				$announcement->title	= $row['title'];
				$announcement->body		= $row['body'];
				$announcement->officerID= $row['officer'];
				$announcement->authorID	= $row['author'];
				
				$announcements[] = $announcement;
			}
			return $announcements;
		} else {
			throw new Exception("No Announcements found", 1);
		}
		
	}
	const QUERYALL = "SELECT * FROM `announcements` ORDER BY `date`";
} // END
?>