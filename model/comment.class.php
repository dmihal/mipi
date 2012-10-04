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
        $this->item     = $data['item'];
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
        return Query::insert($query);
    }
    
} // END
?>