<?php
$page = new PopupSplit("Announcement");
$page->raw = true;

$announcement;
try{
	$announcement = Announcement::getAnnouncement($_GET[1]);
} catch (Exception $e) {
	$page->rawData = 'The announcement could not be found<br /><a href="#" onclick="$.fancybox.close()">Close</a>';
	return $page;
}
$page->setRight($announcement->body);
$page->setLeft($announcement->getAuthor()->getLink());

return $page;
?>