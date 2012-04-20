<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class Session {
	
	public $user;
	
	function __construct(Member $user)
	{
		$this->user = $user;
	}
} // END
?>