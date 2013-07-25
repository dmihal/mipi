<?php

/**
 * Class for a file to download
 *
 * @package default
 * @author  
 */
class File {
    
    public $id, $owner, $officer, $filename, $localname, $title, $description;
    
    public function __construct($data)
    {
        $this->id = $data['ID'];
        $this->title = $data['title'];
        $this->filename = $data['filename'];
        $this->localname = $data['localname'];
        $this->description = $data['description'];
    }
    /**
     * Get link to the file
     *
     * @return Hyperlink
     * @author  
     */
    function getLink() {
        return new Hyperlink($this->title,'/file/'.$this->id);
    }
    
    /**
     * Get File by ID
     *
     * @return File
     * @author  
     */
    static function getFile($id) {
        $files = self::getFilesFromQuery(sprintf("SELECT * FROM `files` WHERE `ID`='%d';",$id));
        return $files[0];
    }
    /**
     * undocumented function
     *
     * @return void
     * @author  
     */
    static function getFilesByOfficer($officer) {
        $id = ($officer instanceof Officer) ? $officer->id : $officer;
        return self::getFilesFromQuery(sprintf("SELECT * FROM `files` WHERE `officer`=%d ORDER BY `date`ASC",$id));
    }
    
    static function getFilesFromQuery($query)
    {
        $query = new Query($query);
        if ($query->numRows >=1) {
            $files = array();
            while($row = $query->nextRow())
            {
                $file = new self($row);
                
                $files[] = $file;
            }
            return $files;
        } else {
            throw new Exception("No Files found", 1);
        }
    }
    
} // END

?>