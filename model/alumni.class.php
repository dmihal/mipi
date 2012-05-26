<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class Alumni extends Member {
	public $type = Person::ALUMNI;
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