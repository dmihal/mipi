<?php
/**
 * Overloadable Class
 *
 * @package default
 * @author  
 */
abstract class Overloadable {
	private $data;
	
	/**
	 * Set the hidden data array
	 *
	 * @param $data array Data to store
	 */
	function hiddenData(array $data=NULL) {
		if (is_null($data)) {
			return $this->data;
		} else {
			$this->data = $data;
		}
		
	}
	/**
	 * Try to return a hidden field
	 *
	 * @return string
	 * @author  
	 */
	function fieldString($variable) {
		return ($this->__isset($variable)) ? $this->$variable : "";
	}
	public function __set($name, $value)
    {
        //echo "Setting '$name' to '$value'\n";
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        //echo "Getting '$name'\n";
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    /**  As of PHP 5.1.0  */
    public function __isset($name)
    {
        //echo "Is '$name' set?\n";
        return isset($this->data[$name]);
    }

    /**  As of PHP 5.1.0  */
    public function __unset($name)
    {
        //echo "Unsetting '$name'\n";
        unset($this->data[$name]);
    }
} // END
?>