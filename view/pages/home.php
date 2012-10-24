<?php
$page = new Page("Home");

/********** Announcements ****************/
$announcementBox = new Box('announce','Announcements');
$announceList = new BCList();
//print_r($announceList->getJS());
foreach (Announcement::getAnnouncementsFromQuery(Announcement::QUERYALL." LIMIT 0,5") as $value) {
	/* @var $value Announcement */
	$announceList->addElement($value->getLink(), $value->getAuthor()->getLink(),$value->body);
}

//$announceList->addOldElement("Event this Firday", "Steve Kocienski", "We will be doing some crazy fraternity shit this friday");
$announcementBox->setContent($announceList);
$page->addBox($announcementBox,'left');

/********** Messages ****************/
$messagesBox = new Box('messages','Messages');
try {
    $messagesContent = new BCList();
    $messages = Message::getUserMessages(getUser(),5);
    foreach ($messages as $message) {
        /* @var $message Message */
        $read = $message->read ? NULL : "unread";
        $messagesContent->addElement($message->getLink(), $message->getSender()->getLink(),$message->getPreview(),$message->date->format('m/d/Y'),$read);
    }
    $messagesBox->setContent($messagesContent);
} catch(Exception $e) {
    $messagesBox->setContent(new BCStatic("No Messages!"));
}
$page->addBox($messagesBox,'left');

/********** Upcoming Events ****************/
$eventsBox = new Box('events','Upcoming Events');
$eventsList = new BCList();
try {
	$events = Event::getEventsFromQuery(Event::QueryNextFive);
	foreach ($events as $event){
		/* @var $event Event */
		$eventsList->addElement(new Hyperlink($event->name,"/event/description/$event->id"), $event->getOwner()->getLink(),$event->description);
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
        $dob = clone $person->dob;
		$birthdays->addRow($person->getLink(),$dob->modify("+$age years")->format('m/d/Y'),$age);
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
/*$surveys = new Box('surveys','Surveys');
$surveyList = new BCList();
$surveyList->addOldElement("Housing Survey", "Joe Monasky", "Questions about the house","#","user/2");
$surveys->setContent($surveyList);
$page->addBox($surveys,'right');*/

/********* Featured Rushee ********/
try{
    $featuredBox = new Box('featrushee','Do You Know Him?');
    ob_start();
    $rushees = Rushee::getRusheesFromQuery('SELECT * FROM `rushees` ORDER BY RAND() LIMIT 0,1');
    $rushee = $rushees[0];
    /* @var $rushee Rushee */
?>
<a href="/rush/person/<?php echo $rushee->id ?>" style="font-weight: bold" class="userlink">
    <img src="<?php echo $rushee->getPhotoPath() ?>" style="width: 75px;float: left;margin-right:10px;" />
</a>
<a href="/rush/person/<?php echo $rushee->id ?>" style="font-weight: bold" class="userlink"><?php echo $rushee->getName() ?></a>
<p>
    <?php echo $rushee->getYearName() ?><br />
    <?php echo $rushee->fieldString('major') ?>
</p>
<br style="clear: both" />
<?php
    $featuredBox->setContent(new BCStatic(ob_get_clean()));
    $page->addBox($featuredBox,'right');
} catch(Exception $e){
    $emptybox = new Box('emptybox',"No Rushees the DB");
    $emptybox->setContent(new BCStatic('There\'s no rushees in the database! Go meet some freshmen!'));
}

return $page;
?>