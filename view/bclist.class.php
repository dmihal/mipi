<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class BCList implements BoxContent {
	
	public $elements = array();
	
	public function addElement($title,$subtitle,$body,$titlelink= "#",$authorlink="user/12345",$date=NULL)
	{
		$datetag = "";
		if($date)
			$datetag = "<div style=\"float:right\">$date</div>";
		$this->elements[] = array(
			'title'=>	"$datetag<a href=\"$titlelink\" class=\"title\">$title</a>",
		 	'subtitle'=>"<a href=\"$authorlink\" class=\"author userlink\">$subtitle</a>",
		 	'body'=>	$body);
	}
	
	public function getHTML()
	{
		$html = '<div class="wboxbody"><ul class="desclist">';
		foreach ($this->elements as $element) {
			$html .= '<li>';
			$html .= $element['title'].$element['subtitle'];
			$html .= '<div>';
			$html .= $element['body'];
			$html .= '</div></li>';
		}
		$html .= '</ul></div>';
		return $html;
	}
	public function getJS(){
		return NULL;
	}
} // END

?>