<?php
$page = new Page("Messages");

$inbox = new Box("inbox","Inbox");
$msgList = new BCList();
$msgList->addElement("New Message System", "David Mihal", "This is the first message","#","#","3/7/2012");
$inbox->setContent($msgList);
$page->addBox($inbox,'tripple');

$page->section = "message";
return $page;
?>
