<?php
/**
 * Class representing the attributes of a hyperlink
 *
 * @package default
 * @author  
 */
class Hyperlink implements HTMLElement {
    public $title,$url,$class;
    public $style = NULL;
    
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
        $style = ($this->style) ? " style=\"$this->style\"" : "";
        return "<a href=\"$this->url\" class=\"$this->class\"$style>$this->title</a>";
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
    /**
     * Set the URL to a new value
     *
     * @return Hyperlink
     * @author  
     */
    function setUrl($url) {
        $this->url = $url;
        return $this;
    }
    /**
     * Set the Style String
     *
     * @return Hyperlink
     * @author  
     */
    function setStyle($style) {
        $this->style = $style;
        return $this;
    }
} // END
?>