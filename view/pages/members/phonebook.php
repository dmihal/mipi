<?php
$page = new Page("Phonebook");

$members = Member::getMembersFromQuery(Member::QueryAllByName);

$phonebook = new Box("phonebook","Phonebook");
$list = new BCStatic();
ob_start();
?>
<div style="column-count: 3;-webkit-column-count: 3;-webkit-column-rule:solid 1px #999; list-style: none;">
    <ul>
<?php

foreach ($members as $member) {
    /* @var $member Member */
	if (isset($member->cell) && $member->cell) {
		echo '<li><div style="float: right">'.new PhoneNumber($member->cell).'</div><a href="#" class="userlink">'.$member->getLink().'</a></li>';
	}
}

?>
    </ul>
</div>
<?php
$list->content = ob_get_clean();
$phonebook->setContent($list);
$page->addBox($phonebook,'tripple');

$page->section = "message";
return $page;
?>