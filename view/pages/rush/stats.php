<?php
$page = new Page("Rush Stats");

$box1 = new Box("stat","Rush Stats");
$query = new Query("SELECT
    (SELECT count(*) FROM `rushees`) as numrushees,
    (SELECT count(*) FROM `rushees` WHERE `bid`='FALSE') as num_nobid,
    (SELECT count(*) FROM `rushees` WHERE `bid`='TRUE') as num_bid,
    (SELECT count(*) FROM `comments` WHERE `type`='RUSHEE') as comments;");
ob_start();
?>
Rushees: <?php echo $query->getField('numrushees'); ?><br />
Rushees without Bids: <?php echo $query->getField('num_nobid'); ?><br />
Rushees with Bids: <?php echo $query->getField('num_bid'); ?><br />
<br />
Comments: <?php echo $query->getField('comments'); ?><br />
Comments per Rushee: <?php echo ($query->getField('comments')/$query->getField('numrushees')); ?><br />
<?php
$box1->setContent(new BCStatic(ob_get_clean()));
$page->addBox($box1,'left'); 

$query = new Query("SELECT  `owner`, COUNT(*) AS num FROM  `rushees` GROUP BY `owner` ORDER BY `num` DESC ");
$adders = new Box("added","Most added");
$add_tbl = new BCTable();
$add_tbl->header = array("Name","Number");
foreach ($query->rows as $row) {
	$user = Member::getMember($row['owner']);
    $add_tbl->addRow($user->getLink(),$row['num']);
}
$adders->setContent($add_tbl);
$page->addBox($adders,'center');

$query = new Query("SELECT  `brother`, COUNT(*) AS num FROM  `rushees` WHERE `brother` IS NOT NULL GROUP BY `brother` ORDER BY `num` DESC ");
$adders = new Box("added","Most Assigned");
$add_tbl = new BCTable();
$add_tbl->header = array("Name","Number");
foreach ($query->rows as $row) {
    $user = Member::getMember($row['brother']);
    $add_tbl->addRow($user->getLink(),$row['num']);
}
$adders->setContent($add_tbl);
$page->addBox($adders,'right');

return $page;
?>