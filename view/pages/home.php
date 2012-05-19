<?php
$page = new Page("Home");

$announcementBox = new Box('announce','Announcements');
$announceList = new BCList();
//print_r($announceList->getJS());
foreach (Announcement::getAnnouncementsFromQuery(Announcement::QUERYALL." LIMIT 0,5") as $value) {
	/* @var $value Announcement */
	$announceList->addElement($value->title, $value->getAuthor()->getName(), $value->body,"","user/".$value->authorID);
}

//$announceList->addElement("Event this Firday", "Steve Kocienski", "We will be doing some crazy fraternity shit this friday");
$announcementBox->setContent($announceList);
$page->addBox($announcementBox,'left');

$messages = new Box('messages','Messages');
$page->addBox($messages,'left');

$eventsBox = new Box('events','Upcoming Events');
$eventsList = new BCList();
try {
	$events = Event::getEventsFromQuery(Event::QueryNextFive);
	foreach ($events as $event){
		/* @var $event Event */
		$eventsList->addElement($event->name, $event->getOwner()->getName(), "It's an Event!","","user/".$value->authorID);
	}
	unset($events);
	/*$eventsList->addElement("Thurs 9pm - Kappa", "Alex Margiott", "It's Doody week!");
	$eventsList->addElement("Saturday 9pm - Mardi Gras Party", "Landon Aires", "Bring beads...");*/
} catch (Exception $e) {
	$eventsList = new BCStatic("No upcoming events");
}
$eventsBox->setContent($eventsList);
$page->addBox($eventsBox,'center');

$guests = new Box('guests',"Guest Lists");
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
//$guestList->addElement("Mardi Gras Party", "", "Saturday","events/list/10");
$guests->setContent($guestList);
$page->addBox($guests,'right');

$surveys = new Box('surveys','Surveys');
$surveyList = new BCList();
$surveyList->addElement("Housing Survey", "Joe Monasky", "Questions about the house","#","user/2");
$surveys->setContent($surveyList);
$page->addBox($surveys,'right');

return $page;
?>