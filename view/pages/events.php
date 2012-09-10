<?php
$user = getUser();
switch (@$_GET[1]) {
	case 'list':
		$page = Page::getPage('events/listeditor');
		break;
	case 'listsave':
		$list = new GuestList($_POST['event']);
		$males = array();
		$females = array();
		for($i=0;$i<count($_POST['mf']);$i++)
		{
			$males[] = new Person($_POST['mf'][$i],$_POST['ml'][$i]);
		}
		for($i=0;$i<count($_POST['ff']);$i++)
		{
			$females[] = new Person($_POST['ff'][$i],$_POST['fl'][$i]);
		}
		$list->updateUserList($user, $males, $females);
		header("Location: /events/list/$_POST[event]/msg:updated");
		exit;
		break;
	default:
		$page = new Page("Events");
	
		$cal = new Box("calendar","Calendar");
		$calendar = new BCCalendar();
		
		try {
			$events = Event::getEventsFromQuery("SELECT * FROM eventsX WHERE MONTH(start)=$calendar->month AND YEAR(start)=$calendar->year ORDER BY start");
			foreach ($events as $event) {
				/* @var $event Event */
				$calendar->addEvent($event->name, "#", $event->start->format('m'));
			}
		} catch(Exception $e){}
		
		$calendar->addEvent("Test Event", "#", 12);
		$cal->setContent($calendar);
		$page->addBox($cal,'tripple');
		
		break;
}
$page->section = "events";

return $page;
?>
