<?php
/**
 * Contains a private message
 *
 * @package default
 * @author  
 */
class Message {
    
    public $id, $subject, $message, $date;
    private $sender, $reply;
    
    function __construct($data)
    {
        $this->id       = $data['ID'];
        $this->subject  = $data['subject'];
        $this->message  = $data['message'];
        $this->date     = new DateTime($data['date']);
        $this->sender   = $data['sender'];
        $this->reply    = $data['reply'];
    }
    
    /**
     * Return Member object of the sender
     *
     * @return void
     * @author  
     */
    function getSender() {
        return Member::getMember($this->sender);
    }
    /**
     * undocumented function
     *
     * @return void
     * @author  
     */
    static function sendMessage($to,$message,$subject="No Subject",$confidential=false) {
        $querybuilder = new SqlQueryBuilder('insert');
        $querybuilder->setTable('messages');
        $querybuilder->addPair('sender', getUser()->id);
        $querybuilder->addPair('message', $message);
        $querybuilder->addPair('subject', $subject);
        $msgID = Query::insert($querybuilder->buildQuery());
        
        foreach ($to as $personID) {
            $querybuilder = new SqlQueryBuilder('insert');
            $querybuilder->setTable('message_status');
            $querybuilder->addPair('message', $msgID);
            $querybuilder->addPair('user', $personID);
            Query::insert($querybuilder->buildQuery());
        }
    }
    /**
     * Get the number of unread messages for a user, defaults to current
     *
     * @return void
     * @author  
     */
    static function getNumUnread($user=NULL) {
        $user = is_null($user) ? getUser() : $user;
        $query = "SELECT COUNT(*) AS num FROM  `message_status` 
                WHERE  `user` = $user->id AND  `read` =  'FALSE'";
        $query = new Query($query);
        return $query->getField('num');
    }
    /**
     * Get a preview of the message
     *
     * @return void
     * @author  
     */
    function getPreview($length=50) {
        return (strlen($this->message) > $length) ? substr($this->message,0,$length-3).'...' : $this->message;
    }
    /**
     * Gets all messages to a user, defaults to the signed in user
     *
     * @return void
     * @author  
     */
    static function getUserMessages($user=NULL,$num=50)
    {
        $user = getUser();
        $query = "SELECT m.*, s.read as `read` FROM message_status as s, messages as m
                        WHERE s.user = $user->id AND s.message=m.ID ORDER BY date desc LIMIT 0,$num";
        return self::getMessagesFromQuery($query);
    }
    
    static function getMessagesFromQuery($query)
    {
        $query = new Query($query);
        if ($query->numRows >=1) {
            $messages = array();
            while($row = $query->nextRow())
            {
                $message = new Message($row);
                
                $messages[] = $message;
            }
            return $messages;
        } else {
            throw new Exception("No Messages found", 1);
        }
    }
} // END
?>