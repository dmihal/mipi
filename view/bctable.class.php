<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class BCTable implements BoxContent {
	
	public $header;
	public $rows = array();
	
	public function __construct()
	{
		$this->header = func_get_args();
	}
	
	public function addRow()
	{
		$this->rows[] = func_get_args();
	}
	
	public function getHTML()
	{
		$html = "<table class='table'><tr>";
		foreach ($this->header as $value) {
			$html .= "<th>$value</th>";
		}
		$html .= "</tr>";
		foreach ($this->rows as $row) {
			$html .= '<tr>';
			foreach ($row as $value) {
				$html .= "<td>$value</td>";
			}
			$html .= '</tr>';
		}
		$html .= '</table>';
		return $html;
	}
	public function getJS(){
		return NULL;
	}
} // END
?>