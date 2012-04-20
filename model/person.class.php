<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class Person extends Overloadable {
	public $first, $last, $yog, $id;
	public $phone, $email;
	
	public $type;
	const RUSHEE = 1;
	const AM = 2;
	const BROTHER = 3;
	const ALUMNI = 4;
	
	public function __construct($first=NULL,$last=NULL,$id=NULL)
	{
		$this->first	= $first;
		$this->last		= $last;
		$this->id		= $id;
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
} // END
?>