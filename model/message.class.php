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
     * get array of recipients
     *
     * @return array(Member)
     * @author  
     */
    function getRecipients($includeSender=false) {
        $q = new Query("SELECT `user` FROM message_status WHERE message=".$this->id);
        $people = array();
        for ($i=$q->numRows-1; $i >= 0; $i--) { 
            array_unshift($people,Member::getMember($q->getField('user',$i)));
        }
        if ($includeSender){
            array_unshift($people,$this->getSender());
        }
        return $people;
    }
    /**
     * Get message that this message replied to
     *
     * @return Message
     * @author  
     */
    function getReplied() {
        return $this->reply ? self::getMessage($this->reply) : NULL;
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
     * Get message object. If $secure=true, messages will only be fetched if the current user has access to them
     *
     * @return Message
     * @author  
     */
    static function getMessage($id,$secure=true) {
        $query = "SELECT m.*, s.read as `read` FROM message_status as s, messages as m
            WHERE m.ID = $id ". ($secure ? "AND (s.user = ".getUser()->id." OR m.sender =".getUser()->id.")" : "") .
            " AND s.message=m.ID";
        $result = self::getMessagesFromQuery($query);
        if (count($result)==1) {
            return $result[0];
        } else {
            throw new Exception("Message not found", 1);
        }
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