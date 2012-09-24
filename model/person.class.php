<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class Person extends Overloadable {
	public $first, $last, $yog, $id;
	public $phone, $email, $dob, $sex;
	
	public $type;
	const RUSHEE = 1;
	const AM = 2;
	const BROTHER = 3;
	const ALUMNI = 4;
    
    const MALE = 6;
    const FEMALE = 7;
	
	public function __construct($first=NULL,$last=NULL,$id=NULL,$sex=NULL)
	{
		$this->first	= $first;
		$this->last		= $last;
		$this->id		= $id;
        
        $this->setSex($sex);
	}
	
	/**
	 * Get the full name of the person
	 *
	 * @param $lastfirst boolean
	 * @return string 
	 */
	function getName($lastfirst=false) {
		return $lastfirst ? $this->last . ', ' . $this->first : $this->first . ' ' . $this->last;
	}
    function getSex(){
        return ($this->sex==self::FEMALE) ? "Girl" : "Guy";
    }
    public function setSex($sex)
    {
        if ($sex == self::FEMALE or $sex == "Girl") {
            $this->sex = self::FEMALE;
        } elseif($sex == self::MALE or $sex == "Guy"){
            $this->sex = self::MALE;
        }
    }
} // END
?>