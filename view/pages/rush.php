<?php
$page = new Page("Rush");

$box = new Box("rush","Rush");
$peoplelist = new BCPeopleList();
$peoplelist->defaultState = 'thumbnail';
$peoplelist->setColumns("Email","Social","Cell Phone","Pi Number","YOG","Birthday");
$peoplelist->setThumbColumns("Pi Number");

$peoplelist->addPerson("Warren", "Smalle", "user/12345", "",
			"abeleveau@wpi.edu",'<a href="http://www.facebook.com/andrew.beliveau">Facebook</a>',"123456789","&#960;1643","2012","June 8, 1989");

$box->setContent($peoplelist);
$page->addBox($box,'tripple');
$page->section = "rush";
return $page;
?>
