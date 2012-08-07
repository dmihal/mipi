<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class BCList implements BoxContent {
	
	public $elements = array();
    public $header = "";
	
    /**
     * Add element to list
     *
     * @return BCList
     * @author  
     */
    function addElement($title,$subtitle,$body='',$date=null,$class=NULL) {
        $datetag = $date ? "<div style=\"float:right\">$date</div>" : "";
        $this->elements[] = array(
            'title' => $datetag.(($title instanceof Hyperlink) ? $title->addClass('title' )->getHTML() : $title),
            'subtitle'  => ($subtitle instanceof Hyperlink) ? $subtitle->addClass('author')->getHTML() : $subtitle,
            'body'  => $body,
            'class' => $class);
        return $this;
    }
	public function addOldElement($title,$subtitle,$body,$titlelink= "#",$authorlink="user/12345",$date=NULL)
	{
		return $this->addElement(new Hyperlink($title,$titlelink),
                                 new Hyperlink($subtitle,$authorlink,'author userlink'),
                                 $body,
                                 $date);
	}
	
	public function getHTML()
	{
		$html = $this->header.'<div class="wboxbody"><ul class="desclist">';
		foreach ($this->elements as $element) {
			$html .= $element['class'] ? "<li class=\"$element[class]\">" : '<li>';
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