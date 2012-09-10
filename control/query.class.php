<?php
class Query
{
	private $sqlresult, $ittRow = 0,$q;
	public $numRows, $rows = array();
	
	function __construct($query)
	{
		require_once("control/mysql.php");
		
		$this->q = $query;
		$this->sqlresult = mysql_query($query);
		if(!$this->sqlresult) throw new Exception("Query \"$query\" failed");
		$this->numRows = mysql_num_rows($this->sqlresult);
		
		while($row = mysql_fetch_assoc($this->sqlresult))
		{
			$newrow = array();
			foreach($row as $field => $value)
			{
				$newrow[$field] = $this->parse($value);
			}
			$this->rows[] = $newrow;
		}
	}
	/**
	 * Return an associative array from the given row
	 *
	 * @param row int Row number
	 * @return array 
	 */
	public function getRow($row)
	{
		return $this->rows[$row];
	}
	/**
	 * Get the value of a field from a row, defaulting to the first row
	 *
	 * @param field string Field name
	 * @param row int Row number
	 * @return mixed 
	 */
	public function getField($field,$row=0)
	{
		return $this->rows[$row][$field];
	}
	/**
	 * Gets the next row and returns it using getRow. Returns false after all rows returned
	 *
	 * @return array 
	 */
	public function nextRow()
	{
		if ($this->ittRow < $this->numRows)
		{
			$return = $this->getRow($this->ittRow);
			$this->ittRow++;
		}
		else
		{
			$return = false;
		}
		return $return;
	}
	/**
	 * Executes a query and returns the primary key of the inserted row
	 *
	 * @param query string Insert query
	 * @return int Insert id 
	 */
	static public function insert($query)
	{
	    
        require_once("control/mysql.php");
        
		$sql = mysql_query($query);
		return mysql_insert_id();
	}
    /**
     * Executes an update query based on array of values
     *
     * @param tablename Name of the table to update
     * @return array Changed Values
     */
	static public function update($tablename, $whereclause, $old, $new)
	{
		require_once("control/mysql.php");
		
	    $changedvalues = "";
	    foreach($old as $key => $oldvalue) {
	        $newvalue = $new[$key];
	        if($oldvalue != $newvalue) {
	            if($changedvalues != "")
	                $changedvalues .= ", ";
	            
	            $changedvalues .= "`".$key."`=";
	            if(!is_numeric($newvalue))
	                $changedvalues .= "'".$newvalue."'";
	            else
	                $changedvalues .= $newvalue;
	        }
	    }
	   	
		$changed = $changedvalues!="";
		
		if($changed && !mysql_query("UPDATE ".$tablename. " SET ".$changedvalues." WHERE ".$whereclause))
		{
			throw new Exception("Query Error", 1);
			
		}
		
	    return $changed;
	}
	private function parse($value)
	{
		if (is_numeric($value))
		{
			$value = floatval($value);
		}
		elseif (strcasecmp($value,'true')==0)
		{
			$value = true;
		}
		elseif (strcasecmp($value,'false')==0)
		{
			$value = false;
		}
		elseif (strcasecmp($value,'null')==0)
		{
			$value = NULL;
		}
		elseif(@unserialize($value)===true)
		{
			$value = unserialize($value);
		}
		return $value;
	}
	public function debug()
	{
		echo $this->q;
	}
}
?>