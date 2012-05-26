<?php
$page = new Page("Associate Members");

$box = new Box("alums","Associate Members");
$peoplelist = new BCPeopleList();
$peoplelist->defaultState = 'thumbnail';
$peoplelist->setColumns("Email","Social","Cell Phone","YOG","Birthday");

$membersList = Member::getMembersFromQuery(Member::QueryAllAMs);
	
	ChromePhp::log($membersList);
	foreach ($membersList as $person) {
		/* @var $person Member */ 
		$peoplelist->addPerson($person->first, $person->last, '/mipi/user/'.$person->id, $person->getPhotoPath(),
							$person->email,"",$person->fieldString('cell'),$person->yog,$person->dob->format("n/j/Y"));
	}
	
$box->setContent($peoplelist);
$page->addBox($box,'tripple');

return $page;
?>