<?php
$page = new AdminPage('Users',getUser(),array('alpha','gamma','web'));

$brothers = Member::getMembersFromQuery(Member::QueryAllBrothers);

$brotherBox = new Box('brothers','Brothers');
$brotherTable = new BCTable();
$brotherTable->header = array('Name','Username','Pi Number','Actions');
foreach ($brothers as $brother) {
    /* @var $brother Brother */
	$brotherTable->addRow(
    	$brother->getName(),
    	$brother->getUsername(),
    	$brother->getPiNum(true),
    	new Hyperlink('Reset Password','/admin/resetPW/'.$brother->id));
}
$brotherBox->setContent($brotherTable);
$page->addBox($brotherBox,'tripple');

return $page;
?>
