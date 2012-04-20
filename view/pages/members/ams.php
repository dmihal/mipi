<?php
$page = new Page("Associate Members");

$box = new Box("alums","Alumni");
$peoplelist = new BCPeopleList();
$peoplelist->defaultState = 'thumbnail';
$peoplelist->setColumns("Email","Social","Cell Phone","YOG","Birthday");

$peoplelist->addPerson("Warren", "Smalle", "user/12345", "",
			"abeleveau@wpi.edu",'<a href="http://www.facebook.com/andrew.beliveau">Facebook</a>',"123456789","2012","June 8, 1989");

$box->setContent($peoplelist);
$page->addBox($box,'tripple');

return $page;
?>