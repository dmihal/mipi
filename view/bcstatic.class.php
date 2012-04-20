<?php 
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class BCStatic implements BoxContent {
	
	public $content;
	
	public function __construct($content=NULL)
	{
		if (!is_null($content)) {
			$this->content = $content;
		}
	}
	
	public function getHTML()
	{
		return $this->content;
	}
	public function getJS(){
		return NULL;
	}
} // END
?>