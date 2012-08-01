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
	
    public function __construct($data){
        $this->id       = $data['ID'];
        $this->title    = $data['title'];
        $this->body     = $data['body'];
        $this->officerID= $data['officer'];
        $this->authorID = $data['author'];
    }
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
     * Returns Hyperlink to announcement
     *
     * @return Hyperlink
     * @author  
     */
    function getLink() {
        return new Hyperlink($this->title,"/announcement/$this->id","announceLink");
    }
	/**
	 * Get Announcement object
	 * 
	 * @param $query string
	 * @return Announcement
	 */
	static function getAnnouncement($id)
	{
		$announcements = self::getAnnouncementsFromQuery("SELECT * FROM `announcements` WHERE `ID`=$id");
        return $announcements[0];
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
				$announcement = new Announcement($row);
				
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