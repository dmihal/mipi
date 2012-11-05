<?php
/**
 * Generic Member of LCA
 *
 * @package default
 * @property DateTime $dob
 * @author  
 */
class Member extends Person {
	/**
    * @var DateTime 
    */
   	public $dob;
	
	public $bigNum, $email,$yog;
	private $initalVars;
    private static $library;
	
	public function __construct($data)
	{
		$this->id		= $data['ID'];
		$this->first	= $data['nameFirst'];
		$this->last		= $data['nameLast'];
		$this->email	= $data['email'];
		$this->yog		= $data['yog'];
		$this->dob		= new DateTime($data['dob']);

		$this->updateFromDataField($data['data']);
        
        self::$library->add($this->id,$this);
	}
	
	/**
	 * Return the path to the photo of the person
	 * 
	 * @return string
	 */
	function getPhotoPath()
	{
		return file_exists("img/portrait/user$this->id.jpg") ? "/img/portrait/user$this->id.jpg" : "/img/unavailable.jpg";
	}
	/**
	 * Copies a new file to the correct location
	 *
	 * @return void
	 * @author  
	 */
	function moveNewPhoto($file) {
		$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
    	$mime = finfo_file($finfo, $file);
		finfo_close($finfo);
		if ($mime == 'image/jpeg') {
			return move_uploaded_file($file, "./img/portrait/user$this->id.jpg");
		} else {
			return false;
		}
	}
	function getPiNum($htmlchar=false)
	{
		return $htmlchar ? "" : NULL;
	}
	/**
	 * Return the Member object of the person's big
	 *
	 * @return Member
	 * @author  
	 */
	function getBig()
	{
		return self::getMember($this->bigNum);
	}
    /**
     * Returns Hyperlink object to user
     *
     * @return Hyperlink
     * @author  
     */
    function getLink() {
        return new Hyperlink($this->getName(),"/user/$this->id",'userlink');
    }
    
    
    public function __wakeup()
    {
        if(!isset(self::$library)){
            self::$library = new Library();
        }
        self::$library->add($this->id,$this);
    }
    /**
     * Creates new member & returns it
     *
     * @return Member
     * @author  
     */
    static function newMember($username,$password,$type='BROTHER') {
        $query = sprintf("INSERT INTO `users` (`username`,`password`,`type`,`data`) VALUES ('$username',  '%s', '$type', 'a:0:{}');",md5($password));
        $id = Query::insert($query);
        return Member::getMember($id);
    }
	/**
	 * Return member with the given database ID
	 * 
	 * @param $id int DB id
	 * @return Member
	 */
	static function getMember($id)
	{
		$array = self::getMembersFromQuery("SELECT * FROM users WHERE `ID`= $id");
		if (count($array)==1) {
			return $array[0];
		} else {
			throw new Exception("User not found", 1);
		}
	}
	static function getMemberLogin($username,$password)
	{
	    $hash = md5($password);
		$array = self::getMembersFromQuery(sprintf("SELECT * FROM users WHERE
(`username`='%s' OR `pi`=%d) AND
`password`='%s'",$username,intval($username),$hash));
		
		if (count($array)==1) {
			return $array[0];
		} else {
			throw new Exception("Username and Password Incorrect", 1);
		}
		
	}
	/**
	 * Return array of members generated by SQL Query
	 * 
	 * @param $query string
	 * @return array(Member)
	 */
	static function getMembersFromQuery($query)
	{
	    if(!isset(self::$library)){
	        self::$library = new Library();
	    }
        
		$query = new Query($query);
		if ($query->numRows >= 1) {
			$array = array();
			while($row = $query->nextRow())
			{
				$member;
                if (self::$library->exists($row['ID'])){
                    $member = self::$library->get($row['ID']);
                } else {
                    switch ($row['type']) {
                    case 'AM':
                        $member = new AM($row);
                        break;
                    case 'BROTHER':
                        $member = new Brother($row);
                        break;
                    case 'ALUM':
                        $member = new Alumni($row);
                        break;
                    default:
                        throw new Exception("Member type not defined");
                    }
                    $member->start();
                }
                
				$array[] = $member;
				unset($member);
			}
			return $array;
		} else {
			throw new Exception();
		}
	}
	const QueryAll = "SELECT *,pi IS NULL AS isnull FROM users ORDER BY isnull ASC, pi ASC, nameLast ASC";
    const QueryAllByName = "SELECT *,pi IS NULL AS isnull FROM users ORDER BY nameLast ASC";
	const QueryAllBrothers = "SELECT *,pi IS NULL AS isnull FROM users WHERE `type`='BROTHER' ORDER BY isnull ASC, pi ASC, nameLast ASC";
	const QueryAllAlum = "SELECT * FROM users WHERE `type`='ALUM' ORDER BY pi ASC";
	const QueryAllAMs = "SELECT * FROM users WHERE `type`='AM' ORDER BY nameLast";
    
    static function buildTree($parent = NULL)
    {
        if(is_null($parent)){
            $query = new Query("SELECT `ID` FROM `users` WHERE `big` IS NULL ORDER BY `pi`;");
        } else {
            $query = new Query("SELECT `ID` FROM `users` WHERE `big`=$parent ORDER BY `pi`;");
        }
        if($query->numRows==0){
            return NULL;
        }
        $subtree = array();
        while ($row = $query->nextRow()) {
            $subtree[$row['ID']] = self::buildTree($row['ID']);
        }
        return $subtree;
    }
    
	public function save()
	{
		return Query::update('users', "`ID`=".$this->id, $this->initalVars, $this->getDBArray());
	}
    public function setPi($num){
        return Query::update('users', "`ID`=".$this->id, array("pi"=>""), array("pi"=>$num));
    }
	public function start()
	{
		//$this->initalVars = get_object_vars($this);
		$this->initalVars = $this->getDBArray();
	}
	public function getSerializedDataField()
	{
	    $data = $this->hiddenData();
        if (key_exists('homeaddr', $data)) {
            $data['homeaddr'] = urlencode($data['homeaddr']);
        }
		return serialize($data);
	}
	public function updateFromDataField($data)
	{
	    $data = unserialize($data);
	    if (key_exists('homeaddr', $data)) {
			$data['homeaddr'] = urldecode($data['homeaddr']);
		}
		$this->hiddenData($data);
	}
	protected function getDBArray()
	{
		return array(
			"nameFirst"	=>$this->first,
			"nameLast"	=>$this->last,
			"email"		=>$this->email,
			"yog"		=>$this->yog,
			"dob"		=>$this->dob->format('Y-m-d'),
			"data"		=>$this->getSerializedDataField()
			);
	}
} // END
?>