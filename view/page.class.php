<?php
class Page
{
	public $title;
	public $boxes = array(
		"left"		=> array(),
		"center"	=> array(),
		"right"		=> array(),
		"double"	=> array(),
		"tripple"	=> array());
	public $allboxes = array();
	public $raw = false;
	public $rawData;
	public $section = "home";
	public $js;
	public $message = NULL;
	
	public function __construct($title)
	{
		$this->title = $title;
	}
	/**
     * Adds Box to the list of boxes
     * @param Box $box Box object to add
	 * @param string $column Column to place block in 
     */
	public function addBox(Box $box,$column = "left")
	{
		$this->boxes[$column][] = $box;
		$this->allboxes[] = $box;
	}
	/**
     * Return the Box by name
     * @param string $name Name of the box to find 
     * @return Box
     */
	public function getBox($name)
	{
		foreach ($this->boxes as $col => $boxs) {
			foreach ($boxs as $box) {
				if ($box->name==$name) {
					return $box;
				}
			}
		}
		throw new Exception("Box not found", 1);
	}

	/**
	 * Get the HTML for all Boxes & columns on the page
	 *
	 * @return void
	 * @author  
	 */
	function getContent() {
		$html = "";
		foreach ($this->boxes as $column => $boxes) {
			if ((bool) count($boxes)) {
				$html .= "<div class=\"column $column\">";
				foreach ($boxes as $box) {
					$html .= $box->getHTML();
				}
				$html .= "</div>";
			}
			
		}
	}
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author  
	 */
	function getJS() {
		$return = "";
		if ($this->js)
			$return .= '<script type="text/javascript">'.$this->js.'</script>';
		//print_r($this->allboxes);
		foreach ($this->allboxes as $box) {
			//$content = $box->content;
			//print_r($content);
			if ($js = $box->getJS())
				$return .= '<script type="text/javascript">'.$js.'</script>';
		}
		return $return;
	}
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author  
	 */
	function setMessage($message) {
		$this->message = $message;
	}
	static function getPage($name)
	{
		if (file_exists("view/pages/$name.php")) {
			return include("view/pages/$name.php");
		} else {
			throw new Exception("Page not found", 1);
		}
		
	}
}
?>