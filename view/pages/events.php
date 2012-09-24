<?php
$user = getUser();
switch (@$_GET[1]) {
	case 'list':
		$page = Page::getPage('events/listeditor');
		break;
    case 'blacklist':
        $page = Page::getPage('events/blacklist');
        break;
    case 'update':
        $list = new GuestList($_POST['event']);
        $guests = array();
        for ($i=0; $i < count($_POST['sex']) && $i < count($_POST['first']) && $i < count($_POST['last']); $i++) {
            if($_POST['first'][$i]!=="" and $_POST['last'][$i]!=""){
                $guests[] = new Person($_POST['first'][$i],$_POST['last'][$i],0,$_POST['sex'][$i]);
            }
        }
        $list->updateList(getUser(), $guests);
        header("Location: /events/list/$_POST[event]/msg:updated");
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
				$calendar->addEvent($event->name, "/events/list/$event->id", $event->start->format('d'));
			}
		} catch(Exception $e){}
		
		$cal->setContent($calendar);
		$page->addBox($cal,'tripple');
		
		break;
}
$page->section = "events";

return $page;
?>
