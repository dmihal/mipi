<?php
$page = new Page("Home");

/********** Announcements ****************/
$announcementBox = new Box('announce','Announcements');
$announceList = new BCList();
//print_r($announceList->getJS());
foreach (Announcement::getAnnouncementsFromQuery(Announcement::QUERYALL." LIMIT 0,5") as $value) {
	/* @var $value Announcement */
	$announceList->addOldElement($value->title, $value->getAuthor()->getName(), $value->body,"","user/".$value->authorID);
}

//$announceList->addOldElement("Event this Firday", "Steve Kocienski", "We will be doing some crazy fraternity shit this friday");
$announcementBox->setContent($announceList);
$page->addBox($announcementBox,'left');

/********** Messages ****************/
$messagesBox = new Box('messages','Messages');
$messagesContent = new BCList();
$messages = Message::getUserMessages(getUser(),5);
foreach ($messages as $message) {
    /* @var $message Message */
    $messagesContent->addOldElement($message->subject, $message->getSender()->getName(), $message->getPreview(),'#','/user/'.$message->getSender()->id,$message->date->format('m/d/Y'));
}
$messagesBox->setContent($messagesContent);
$page->addBox($messagesBox,'left');

/********** Upcoming Events ****************/
$eventsBox = new Box('events','Upcoming Events');
$eventsList = new BCList();
try {
	$events = Event::getEventsFromQuery(Event::QueryNextFive);
	foreach ($events as $event){
		/* @var $event Event */
		$eventsList->addOldElement($event->name, $event->getOwner()->getName(), "It's an Event!","","user/".$value->authorID);
	}
	unset($events);
	/*$eventsList->addOldElement("Thurs 9pm - Kappa", "Alex Margiott", "It's Doody week!");
	$eventsList->addOldElement("Saturday 9pm - Mardi Gras Party", "Landon Aires", "Bring beads...");*/
} catch (Exception $e) {
	$eventsList = new BCStatic("No upcoming events");
}
$eventsBox->setContent($eventsList);
$page->addBox($eventsBox,'center');

/********** Upcoming Birthdays ****************/
$birthdayBox = new Box('bday','Upcoming Birthdays');
$birthdays = new BCTable('Name','Date','Age');
try {
	$people = Member::getMembersFromQuery("SELECT *,
		dob + INTERVAL(YEAR(CURRENT_TIMESTAMP) - YEAR(dob)) + 0 YEAR AS currbirthday
		FROM users
		ORDER BY CASE WHEN currbirthday < CURRENT_TIMESTAMP
		THEN currbirthday + INTERVAL 1 YEAR
		ELSE currbirthday
		END
		LIMIT 0,5");
	foreach ($people as $person) {
		/* @var $person Member */
		$age = $person->dob->diff(new DateTime())->y +1;
		$birthdays->addRow($person->getName(),$person->dob->format('m/d/Y'),$age);
	}
} catch (Exception $e) {
	$birthdays = new BCStatic("No upcoming birthdays");
}
$birthdayBox->setContent($birthdays);
$page->addBox($birthdayBox,'center');

/********** Guest Lists ****************/
$guests = new Box('guests',"Guest Lists");
$guestList = new BCList();
try{
	$events = Event::getEventsFromQuery(Event::QueryOpenLists);
	foreach ($events as $key => $event) {
		/* @var $event Event */
		$guestList->addOldElement($event->name, "", "","events/list/".$event->id);
	}
	unset($events);
}catch(Exception $e){
	$guestList = new BCStatic("No open guest lists");
}
//$guestList->addOldElement("Mardi Gras Party", "", "Saturday","events/list/10");
$guests->setContent($guestList);
$page->addBox($guests,'right');

/********** Surveys ****************/
$surveys = new Box('surveys','Surveys');
$surveyList = new BCList();
$surveyList->addOldElement("Housing Survey", "Joe Monasky", "Questions about the house","#","user/2");
$surveys->setContent($surveyList);
$page->addBox($surveys,'right');

return $page;
?>