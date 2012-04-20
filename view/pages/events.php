<?php
if(@$_GET[1]=="list")
{
	$page = Page::getPage('events/listeditor');
}
else {
	$page = new Page("Events");
	
	$cal = new Box("calendar","Calendar");
	$calendar = new BCCalendar();
	$calendar->addEvent("Test Event", "#", 12);
	$cal->setContent($calendar);
	$page->addBox($cal,'tripple');
}
$page->section = "events";

return $page;
?>
