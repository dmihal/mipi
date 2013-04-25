<?php
/**
 * 
 */
class PhoneNumber{
	
    public $start, $full, $area, $exchange, $sufix;
    
	function __construct($number) {
        $this->start = $number;
	    $number = preg_replace("/[^\d\s]/", "",$number);
		preg_match('/^1?(\d{3})(\d{3})(\d{4})(\d*)$/', $number,$result);
        @list($this->full,$this->area,$this->exchange,$this->sufix) = $result;
	}
    public function __toString()
    {
        return $this->sufix ? "($this->area)&nbsp;$this->exchange&#8209;$this->sufix" : $this->start;
    }
}

?>