<?php
$page = new Page("Guest Lists");

$open = new Box("open","Open Lists");
$guestList = new BCList();
try{
	$events = Event::getEventsFromQuery(Event::QueryOpenLists);
	foreach ($events as $key => $event) {
		/* @var $event Event */
		$guestList->addElement($event->name, "", "","events/list/".$event->id);
	}
	unset($events);
}catch(Exception $e){
	$guestList = new BCStatic("No open guest lists");
}
$open->setContent($guestList);
$page->addBox($open,'double');

$closed = new Box("closed","Closed Lists");
$guestList = new BCList();
try{
	$events = Event::getEventsFromQuery(Event::QueryClosedLists);
	foreach ($events as $key => $event) {
		/* @var $event Event */
		$guestList->addElement($event->name, "", "","events/list/".$event->id);
	}
	unset($events);
}catch(Exception $e){
	$guestList = new BCStatic("No open guest lists");
}
$closed->setContent($guestList);
$page->addBox($closed,'right');

return $page;
?>