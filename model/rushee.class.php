<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class Rushee extends Person {
	public $type = Person::RUSHEE;
	
	/**
	 * Return the path to the photo of the person
	 * 
	 * @return string
	 */
	function getPhotoPath()
	{
		return file_exists("img/rushpics/$this->id.jpg") ? "/mipi/img/rushpics/$this->id.jpg" : "/mipi/img/unavailable.jpg";
	}
	/**
	 * Copies a new file to the correct location
	 *
	 * @return void
	 * @author  
	 */
	function moveNewPhoto($file) {
		$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
    	$mime = finfo_file($finfo, $file);
		finfo_close($finfo);
		if ($mime == 'image/jpeg') {
			return move_uploaded_file($file, "/opt/lampp/htdocs/mipi/img/rushpics/$this->id.jpg");
		} else {
			return false;
		}
	}
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author  
	 */
	function getYearName() {
		$thisYear = new DateTime();
		$thisYear->modify('+6 months');
		$yearsLeft = $this->yog - $thisYear->format('Y');
		$names = array("Senior","Junior","Sophamore","Freshman");
		return $names[$yearsLeft];
	}
	/**
	 * Get Rushee by ID
	 *
	 * @return Rushee
	 * @author  
	 */
	static function getRushee($id) {
		$array = self::getRusheesFromQuery("SELECT * FROM rushees WHERE `ID`= $id");
		if (count($array)==1) {
			return $array[0];
		} else {
			throw new Exception("Rushee not found", 1);
		}
	}
	/**
	 * Return array of members generated by SQL Query
	 * 
	 * @param $query string
	 * @return array(Rushee)
	 */
	static function getRusheesFromQuery($query)
	{
		$query = new Query($query);
		if ($query->numRows >= 1) {
			$array = array();
			while($row = $query->nextRow())
			{
				$rushee = new self();
				
				$rushee->id		= $row['ID'];
				$rushee->first	= $row['first'];
				$rushee->last	= $row['last'];
				$rushee->email	= $row['email'];
				$rushee->phone	= $row['phone'];
				$rushee->yog	= $row['class'];
				
				$array[] = $rushee;
				unset($rushee);
			}
			return $array;
		} else {
			throw new Exception();
		}
	}
	
} // END
?>