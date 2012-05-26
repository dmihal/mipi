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
	function getPiNum($htmlchar=false)
	{
		return ($htmlchar) ? "<span style=\"font-family: serif\">&pi;</span>$this->piNum" : $this->piNum;
	}
	
} // END
?>