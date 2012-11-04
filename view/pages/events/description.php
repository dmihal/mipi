<?php
$page = new Page("Event Description");
$event = Event::getEvent($_GET[2]);

$box = new Box('description',$event->name);
$box->setContent(new BCStatic(""));
$page->addBox($box,'double');

$guestlist = new Box('list',"Guestlist");
$content = $event->hasGL ? new Hyperlink("View/Edit Guestlist","/events/list/".$event->id,"") : "This event does not have a guest list";
$guestlist->setContent(new BCStatic($content));
$page->addBox($guestlist,'right');

return $page;
?>
