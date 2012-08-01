<?php
/**
 * Class representing the attributes of a hyperlink
 *
 * @package default
 * @author  
 */
class Hyperlink implements HTMLElement {
    public $title,$url,$class;
    
    public function __construct($title,$url='#',$class='')
    {
        $this->title = $title;
        $this->class = $class;
        $this->url   = $url;
    }
    
    /**
     * Return HTML <a> tag
     *
     * @return string
     * @author  
     */
    public function getHTML() {
        return "<a href=\"$this->url\" class=\"$this->class\">$this->title</a>";
    }
    public function __toString() {
        return $this->getHTML();
    }
    /**
     * Add class to string
     *
     * @return Hyperlink
     * @author  
     */
    function addClass($class) {
        $this->class .= " $class";
        return $this;
    }
} // END
?>