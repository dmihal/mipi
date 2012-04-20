<?php
switch (@$_GET[1]) {
	case 'list':
		$page = Page::getPage('events/listeditor');
		break;
	case 'listsave':
		
		break;
	default:
		$page = new Page("Events");
	
		$cal = new Box("calendar","Calendar");
		$calendar = new BCCalendar();
		$calendar->addEvent("Test Event", "#", 12);
		$cal->setContent($calendar);
		$page->addBox($cal,'tripple');
		break;
}
$page->section = "events";

return $page;
?>
