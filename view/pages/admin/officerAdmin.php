<?php
$officer = Officer::getOfficerByName(@$_GET['officer']);

$page = new AdminPage($officer->name,getUser(),array($officer->name));

$announcements = new Box("announcements","Announcements");
$announceList = new BCList();
ob_start();
?>
<a href="/admin/announcement/new:<?php echo $officer->name ?>">New Announcement</a>
<?php
$announceList->header = ob_get_clean();
foreach ($officer->getAnnouncements() as $announcement) {
    /* @var $announcement Announcement */
    $link = new Hyperlink($announcement->title,"/admin/announcement/".$announcement->id,"");
  	$announceList->addElement($link, "",$announcement->body,$announcement->date->format('m/d/Y'));
}
$announcements->setContent($announceList);
$page->addBox($announcements);

return $page;
?>