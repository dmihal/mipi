<?php
$officer = Officer::getOfficerByName($_GET[1]);
$person = $officer->getMember();

$page = new Page("$officer->title");

if (in_array($officer, Officer::getOfficersByUser(getUser()))){
    $admin = new Box('admin','');
    $admin->setContent(new BCStatic('<a href="/admin/officer:'.$officer->name.'">Admin Page</a>'));
    $page->addBox($admin);
}


$details = new Box("details",$officer->title);
$detContent = new BCStatic();
ob_start();
echo "<p>$officer->subtitle</p>";
if($person)
{
	echo "<p>".$person->getName()."</p>";
}
//?><?php
$detContent->content = ob_get_clean();
$details->setContent($detContent);
$page->addBox($details,'left');

$announce = new Box("announcements","Announcements");
$announceList;
try
{
	$announceList = new BCList();
	foreach ($officer->getAnnouncements() as $announcement) {
	    /* @var $announcement Announcement */
	    $announceList->addElement($announcement->getLink(), $announcement->getAuthor()->getLink(),$announcement->body);
	}
} catch (Exception $e) {
	$announceList = new BCStatic("No announcements!");
}

$announce->setContent($announceList);
$page->addBox($announce,'double');

return $page
?>