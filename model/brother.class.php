<?php
/**
 * An active undergraduate brother of LCA
 *
 * @package default
 * @author  
 */
class Brother extends Member {
	public $type = Person::BROTHER;
	private $piNum;
	
	public function __construct($data)
	{
		parent::__construct($data);
		$this->piNum = $data['pi'];
	}
    /**
     * Get the brother's pi number
     *
     * @return String/int
     * @param $htmlchar set true if html version should be returned
     */
	function getPiNum($htmlchar=false)
	{
	    //Brother Morin gets his own 3 lines of code!
	    if ($this->piNum==750 and $htmlchar) {
			return "<span style=\"font-family: serif\">&beta;&nu;</span>$this->piNum";
		}
		return ($htmlchar) ? "<span style=\"font-family: serif\">&pi;</span>$this->piNum" : $this->piNum;
	}
	
} // END
?>