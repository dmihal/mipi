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
	public $id, $name, $end, $hasGL, $owner;
	
	
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
		return self::getEventsFromQuery("SELECT * FROM `eventsX` WHERE `id`=$id;");
	}
	static function getEventsFromQuery($query)
	{
		$query = new Query($query);
		if ($query->numRows >=1) {
			$events = array();
			while($row = $query->nextRow())
			{
				$event = new Event();
				$event->id		= $row['ID'];
				$event->name	= $row['name'];
				$event->start	= new DateTime($row['start']);
				$event->end		= new DateTime($row['end']);
				$event->hasGL	= $row['guestlist'];
				$event->owner	= $row['owner'];
				
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