<?php
$page = new Page('Rush Votes');

$rushees = Rushee::getRusheesFromQuery("SELECT * FROM `rushees` ORDER BY rush_rank(ID) DESC;");

$box = new Box('rushees',"Rushees");
$table = new BCTable();
$table->header = array("","Name");
foreach ($rushees as $rushee) {
	/* @var $rushee Rushee */
	$up = new Hyperlink("Up","#");
    $up->onclick = "return vote($rushee->id,'up',this)";
    $down = new Hyperlink("Down","#");
    $down->onclick = "return vote($rushee->id,'down',this)";
	$table->addRow("$up<br />$down",$rushee->getName());
}
$box->setContent($table);
$page->addBox($box,'tripple');

return $page;
?>
