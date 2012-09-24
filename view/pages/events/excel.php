<?php
require 'control/excel.class.php';
if (!($e = @$_GET[2])) {
	echo "Error: no event given";
    exit;
}
$list = new GuestList($e);
$data = array("",array("First","Last","Brother","Pi"));
foreach ($list->guests as $guest) {
    $bro = Member::getMember($guest['owner']);
	$data[]= array($guest['guest']->first,$guest['guest']->last,$bro->getName(),$bro->getPiNum());
}
unset($data[0]);

$xls = new Excel_XML('UTF-8', false, 'Guests');
$xls->addArray($data);
$xls->generateXML('guestlist');
//var_dump($data);
exit;
?>