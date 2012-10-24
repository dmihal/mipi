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
    /**
     * Get a link to the user's facebook profile
     *
     * @return Hyperlink
     * @author  
     */
    function getFBLink() {
        if(isset($this->fbid) && $this->fbid){
            return new Hyperlink('Facebook',"http://www.facebook.com/".$this->fbid,'facebook');
        } else {
            return new Hyperlink('','','nulllink');
        }
    }
    /**
     * Returns URL to facebook profile thumbnal
     *
     * @return string
     * @author  
     */
    function getFBPic() {
        return isset($this->fbid) ? "http://graph.facebook.com/".$this->fieldString('fbid')."/picture" : '';
    }
    /**
     * Return Hyperlink to twitter profile
     *
     * @return Hyperlink
     * @author  
     */
    function getTwitterLink() {
        if(isset($this->twitid) && $this->twitid){
            return new Hyperlink('Twitter',"http://www.twitter.com/".$this->twitid,'twitter');
        } else {
            return new Hyperlink('','','nulllink');
        }
    }
    /**
     * Return URL to twitter prof pic
     *
     * @return string
     * @author  
     */
    function getTwitterPic() {
        return isset($this->twitid) ? "https://api.twitter.com/1/users/profile_image?screen_name=".$this->fieldString('twitid') : '';
    }
} // END
?>