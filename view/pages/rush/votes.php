<?php
$page = new Page('Rush Votes');

$rushees = Rushee::getRusheesFromQuery("SELECT * FROM `rushees` ORDER BY rush_rank(ID) DESC;");

$box = new Box('rushees',"Rushees");
$table = new BCTable();
$table->header = array("","Photo","Name","Year");
foreach ($rushees as $rushee) {
	/* @var $rushee Rushee */
	$vote = $rushee->getVotes(getUser());
    $upclass   = ($vote == "UP")   ? "voted" : "";
    $downclass = ($vote == "DOWN") ? "voted" : "";
    
	$up = new Hyperlink("Ready to Vote","#",$upclass);
    $up->onclick = "return vote($rushee->id,'up',this)";
    $down = new Hyperlink("Not Ready to Vote","#",$downclass);
    $down->onclick = "return vote($rushee->id,'down',this)";
	$table->addRow("$up<br />$down",'<img src="'.$rushee->getPhotoPath().'" style="width:75px;" />',$rushee->getLink(),$rushee->getYearName());
}
$box->setContent($table);
$page->addBox($box,'tripple');

return $page;
?>
