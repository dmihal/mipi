<?php
switch(@$_GET[1])
{
case 'ams':
	$page = Page::getPage('members/ams');
	break;
case 'alum':
	$page = Page::getPage('members/alum');
	break;
case 'phonebook':
	$page = Page::getPage('members/phonebook');
	break;
default:
	$page = new Page("Brothers");
	
	$box = new Box("members","Brothers");
	$peoplelist = new BCPeopleList();
	$peoplelist->defaultState = 'thumbnail';
	$peoplelist->setColumns("Email","Social","Cell Phone","Pi Number","YOG","Birthday");
	$peoplelist->setThumbColumns("Pi Number");

	$membersList = Member::getMembersFromQuery(Member::QueryAll);
	
	ChromePhp::log($membersList);
	foreach ($membersList as $person) {
		/* @var $person Member */ 
		$peoplelist->addPerson($person->first, $person->last, 'user/'.$person->id, "/mipi/img/2010beliveau.png",
							$person->email,"",$person->fieldString('cell'),$person->getPiNum(true),$person->yog,$person->dob->format("n/j/Y"));
	}
	
	$box->setContent($peoplelist);
	$page->addBox($box,'tripple');
}
$page->section = "members";

return $page;
?>