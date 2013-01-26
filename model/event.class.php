<?php
/**
 * undocumented class
 *
 * @package default
 * @property $start DateTime
 * @author  
 */
class Event {
	/**
     * Date the event begins
     * @var DateTime
     */
	public $start;
    /**
     * Date the event list is unlocked
     * @var DateTime
     */
    public $unlock;
    /**
     * Date the event list is unlocked
     * @var DateTime
     */
    public $close;
	public $id, $name, $end, $hasGL, $owner, $guestsPerPerson, $description;
	
	public function __construct($data){
	    $this->id       = $data['ID'];
        $this->name     = $data['name'];
        $this->start    = new DateTime($data['start']);
        $this->end      = new DateTime($data['end']);
        $this->hasGL    = $data['guestlist'];
        $this->owner    = $data['owner'];
        $this->unlock   = $data['listunlocks'] ? new DateTime($data['listunlocks']) : NULL;
        $this->guestsPerPerson = $data['guestsperperson'];
        $this->description = $data['description'];
        $this->close    = $data['listcloses'] ? new DateTime($data['listcloses']) : NULL;
	}
	/**
	 * Get owner of event
	 *
	 * @return Member
	 * @author  
	 */
	function getOwner() {
		return Member::getMember($this->owner);
	}
	/**
	 * Get event by ID
	 *
	 * @return Event
	 */
	static function getEvent($id) {
	    $events = self::getEventsFromQuery(sprintf("SELECT * FROM `eventsX` WHERE `id`=%d;",$id));
		return $events[0];
	}
	static function getEventsFromQuery($query)
	{
		$query = new Query($query);
		if ($query->numRows >=1) {
			$events = array();
			while($row = $query->nextRow())
			{
				$event = new Event($row);
				
				$events[] = $event;
			}
			return $events;
		} else {
			throw new Exception("No Events found", 1);
		}
	}
	
	const QueryNextFive		= "SELECT * FROM eventsX WHERE `start`>CURRENT_TIMESTAMP() ORDER BY start LIMIT 0,5";
	const QueryOpenLists 	= "SELECT * FROM eventsX WHERE `start`>CURRENT_TIMESTAMP() AND `guestlist`='true' ORDER BY start LIMIT 0,5";
	const QueryClosedLists 	= "SELECT * FROM eventsX WHERE `start`<CURRENT_TIMESTAMP() AND `guestlist`='true' ORDER BY start LIMIT 0,5";
} // END
?>