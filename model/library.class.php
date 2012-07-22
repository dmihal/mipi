<?php
/**
 * Stores objects constructed from databases
 *
 * @package default
 * @author  
 */
class Library {
	
	private $library = array();
	
	function __construct()
	{
		
	}
	
	/**
	 * Adds object to library
	 *
	 * @return void
	 * @author  
	 */
	function add($id,$object) {
		$this->library[$id]	= $object;
	}
	
	/**
	 * Returns object or null if doesnt exist
	 *
	 * @return void
	 * @author  
	 */
	function get($id) {
		return $this->exists($id) ? $this->library[intval($id)] : NULL;
	}
    /**
     * undocumented function
     *
     * @return void
     * @author  
     */
    function exists($id) {
        return array_key_exists(intval($id), $this->library);
    }
} // END
?>