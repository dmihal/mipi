<?php
$page = new Page("Announcement");
$page->raw = true;

$announcement;
try{
	$user = Announcement::($_GET[1]);
} catch (Exception $e) {
	//$page->rawData = '<script type="application/javascript">$.fancybox.close();</script>';
	$page->rawData = 'The user could not be found<br /><a href="#" onclick="$.fancybox.close()">Close</a>';
	return $page;
}


return $page;
?>