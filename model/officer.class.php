<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class Officer extends Overloadable{
	
	public $id,$name,$title,$subtitle,$memberID;
    
    private static $library;
	
	public function __construct(array $data)
	{
		$this->name       = $data['name'];
		$this->id         = $data["ID"];
		$this->memberID	  = $data["member"];
		$this->title      = $data["title"];
		$this->subtitle	  = $data["subtitle"];
        $this->hiddenData(json_decode($data['data'],true));
        
        self::$library->add($this->id,$this);
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
    /**
     * undocumented function
     *
     * @return void
     * @author  
     */
    function getLink() {
        return new Hyperlink($this->name,"/officer/$this->name");
    }
    /**
     * Get officer by ID
     *
     * @return Officer
     * @author  
     */
    static function getOfficer($id) {
        $officers = self::getOfficersByQuery(sprintf("SELECT * FROM officers WHERE `ID`=%d",$id));
        return $officers[0];
    }
    /**
     * undocumented function
     *
     * @return Officer
     * @author  
     */
    static function getOfficerByName($name) {
        $officers = self::getOfficersByQuery("SELECT * FROM officers WHERE `name`='$name'");
        return $officers[0];
    }
    /**
     * undocumented function
     *
     * @return void
     * @author  
     */
    static function getOfficersByUser($user) {
        $id = ($user instanceof Member) ? $user->id : $user;
        return self::getOfficersByQuery("SELECT * FROM officers WHERE `member`=$id;");
    }
    /**
     * undocumented function
     *
     * @return array
     * @author  
     */
    static function getOfficersByQuery($query) {
        if(!isset(self::$library)){
            self::$library = new Library();
        }
        
        $query = new Query($query);
        if ($query->numRows >= 1) {
            $array = array();
            while($row = $query->nextRow())
            {
                $officer;
                if (self::$library->exists($row['ID'])){
                    $officer = self::$library->get($row['ID']);
                } else {
                    $officer = new Officer($row);
                }
                
                $array[] = $officer;
            }
            return $array;
        } else {
            throw new Exception();
        }
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