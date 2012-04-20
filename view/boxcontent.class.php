<?php
/**
 * undocumented interface
 *
 * @package default
 * @author  
 */
interface BoxContent {
	/**
	 * Get the HTML for a box
	 *
	 * @return string
	 */
	public function getHTML();
	/**
	 * Get the JavaScript for a box
	 *
	 * @return string
	 */
	public function getJS();
} // END interface BoxContent
?>