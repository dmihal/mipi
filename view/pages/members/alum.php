<?php
$page = new Page("Alumni");
	
$box = new Box("alums","Alumni");
$peoplelist = new BCPeopleList();
$peoplelist->defaultState = 'thumbnail';
$peoplelist->setColumns("Email","Social","Cell Phone","Pi Number","YOG","Birthday");
$peoplelist->setThumbColumns("Pi Number");

$membersList = Member::getMembersFromQuery(Member::QueryAllAlum);
	
	ChromePhp::log($membersList);
	foreach ($membersList as $person) {
		/* @var $person Member */ 
		$peoplelist->addPerson($person->first, $person->last, '/mipi/user/'.$person->id, $person->getPhotoPath(),
							$person->email,"",$person->fieldString('cell'),$person->getPiNum(true),$person->yog,$person->dob->format("n/j/Y"));
	}

$box->setContent($peoplelist);
$page->addBox($box,'tripple');

return $page;
?>