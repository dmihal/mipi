<?php
/**
 * An active undergraduate brother of LCA
 *
 * @package default
 * @author  
 */
class Brother extends Member {
	public $type = Person::BROTHER;
	
	public function __construct()
	{
		
	}
	function getPiNum($htmlchar=false)
	{
		return ($htmlchar) ? "<span style=\"font-family: serif\">&pi;</span>$this->piNum" : $this->piNum;
	}
	
} // END
?>