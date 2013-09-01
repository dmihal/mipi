<?php
/**
 * Class representing the attributes of a hyperlink
 *
 * @package default
 * @author  
 */
class Hyperlink implements HTMLElement {
    public $title,$url,$onclick;
    private $attributes = array();
    
    public function __construct($title,$url='#',$class='',$attributes=null)
    {
        $this->title = $title;
        $this->attributes = $attributes ? $attributes : array();
        if($class)
            $this->attributes['class'] = $class;
        $this->url = $this->attributes['href']   = $url;
    }
    
    /**
     * Return HTML <a> tag
     *
     * @return string
     */
    public function getHTML() {
        $attributestring = '';
        foreach ($this->attributes as $attribute => $value) {
            $attributestring .= "$attribute=\"$value\" ";
        }
        $onclick = ($this->onclick) ? " onclick=\"$this->onclick\"" : "";
        return "<a href=\"$this->url\" $attributestring $onclick>$this->title</a>";
    }
    public function __toString() {
        return $this->getHTML();
    }
    /**
     * Add class to string
     *
     * @return Hyperlink
     */
    function addClass($class) {
        if (isset($this->attributes['class'])) {
            $this->attributes['class'] .= " $class";
        } else {
            $this->attributes['class'] = "$class";
        }
        return $this;
    }
    /**
     * Set the URL to a new value
     *
     * @return Hyperlink
     */
    function setUrl($url) {
        $this->url = $url;
        return $this;
    }
    /**
     * Set the Style String
     *
     * @return Hyperlink
     */
    function setStyle($style) {
        $this->setAttribute('style', $style);
        return $this;
    }
    /**
     * Set an attribute of the link
     *
     * @return Hyperlink
     */
    function setAttribute($attribute,$value) {
        $attributes[$attribute] = $value;
        return $this;
    }
} // END
?>