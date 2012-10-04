<?php 
/**
 * comment on an item
 *
 * @package default
 * @author  
 */
class Comment {
    
    public $owner, $item, $message, $date;
    
    public function __construct($data)
    {
        $this->owner    = $data['owner'];
        $this->item     = $data['subject'];
        $this->date     = new DateTime($data['date']);
        $this->message  = $data['body'];
    }
    
    public function getOwner()
    {
        return Member::getMember($this->owner);
    }
    static function addComment($subject,$owner,$type,$body)
    {
        if (is_object($owner)) {
            $owner = $owner->id;
        }
        
        $query = sprintf("INSERT INTO `comments` (
            `owner` ,`subject` ,`type` ,`body`
            ) VALUES (
            '%d','%d','%s','%s');",
            $owner, $subject, mysql_escape_string($type), mysql_escape_string($body));
        $id = Query::insert($query);
        return self::getComment($id);
    }
    static function getComment($id)
    {
        $comments = self::getCommentsFromQuery("SELECT * FROM `comments` WHERE `ID`=$id");
        return $comments[0];
    }
    static function getCommentsFromQuery($query)
    {
        $query = new Query($query);
        if ($query->numRows >= 1) {
            $array = array();
            while($row = $query->nextRow())
            {
                $array[] = new self($row);
            }
            return $array;
        } else {
            throw new Exception("Error Querying Comments", 1);
        }
    }
    
} // END
?>