<?php
$officer = Officer::getOfficer($_POST['officer']);
$announcement = Announcement::newAnnouncement($_POST['officer'], getUser()->id, $_POST['title'], $_POST['body']);
header("/officer/".$_POST['officer']);
?>