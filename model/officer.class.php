<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class Officer extends Overloadable{
	
	public $id,$name,$title,$subtitle,$memberID;
    
    private $initialVars;
    private static $library;
	
	public function __construct(array $data)
	{
		$this->name       = $data['name'];
		$this->id         = $data["ID"];
		$this->memberID	  = $data["member"];
		$this->title      = $data["title"];
		$this->subtitle	  = $data["subtitle"];
        $this->hiddenData(json_decode($data['data'],true));
        
        $this->initialVars = $this->getDBArray();
        
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
     * Saves any changed atributes
     *
     * @return boolean Whether it was updated
     */
    public function save()
    {
        return Query::update('officers', "`ID`=".$this->id, $this->initialVars, $this->getDBArray());
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
        try {
            return self::getOfficersByQuery("SELECT * FROM officers WHERE `member`=$id;");
        } catch (Exception $e){
            return array();
        }
        
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
            throw new Exception("Error querying for officers");
        }
    }
    /**
     * return an associative array of officers
     * Ex: ['alpha'] => "Alpha"
     *
     * @return array
     * @author  
     */
	static function getOfficerLists($elected=true,$page=true)
	{
		$elected = $elected ? 'true' : 'false';
        $page    = $page ? " AND `page`='1'" : "";
		$officers = array();
		$q = new Query("SELECT name,title FROM officers WHERE `elected` like '$elected'$page ORDER BY `sort`");
		while($officer = $q->nextRow())
		{
			$officers[$officer['name']] = $officer['title'];
		}
		return $officers;
	}
    private function getDBArray()
    {
        return array(
            "name"     => $this->name,
            "member"      => $this->memberID,
            "title"     => $this->title,
            "subtitle"     => $this->subtitle,
            "data"      => json_encode($this->hiddenData())
            );
    }
} // END
?>