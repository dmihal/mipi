<?php
/**
 * 
 */
class NavElement {
	
	public $link, $title, $class;
	
	function __construct($title, $link="#", $class="") {
		list($this->link, $this->title, $this->class) = array($link, $title, $class);
	}
}

?>