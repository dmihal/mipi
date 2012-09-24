<?php
$page = new AdminPage("Blacklist",getUser(),array('iota','epsilon','alpha'));

if(isset($_POST['first']) && isset($_POST['last']))
{
    Query::insert("INSERT INTO `blacklist` (`firstname`,`lastname`,`yog`,`reason`)VALUES ('$_POST[first]', '$_POST[last]', '$_POST[yog]',  '$_POST[reason]');");
}


$add = new Box("addbox","Add to Blacklist");
ob_start();
?>
<form method="POST">
    <label>First: <input name="first" /></label><br />
    <label>Last: <input name="last" /></label><br />
    <label>YOG: <input type="number" name="yog" /></label><br />
    <label>Reason: <textarea name="reason"></textarea></label><br />
    <button type="submit">Add</button>
</form>
<?php
$add->setContent(new BCStatic(ob_get_clean()));
$page->addBox($add,'left');

$status = new Box('status',"Issues");
$query = new Query("SELECT guests.*, blacklist.yog, blacklist.reason FROM `guests`,`blacklist` WHERE guests.first LIKE blacklist.firstname AND guests.last LIKE blacklist.lastname ORDER BY `event`");
$issueTable = new BCTable();
$issueTable->header = array("Name","Added By","YOG","Reason");
$event = 0;
while($row = $query->nextRow()){
    if ($row['event']!=$event) {
        $event = $row['event'];
        $e = Event::getEvent($event);
        $issueTable->addRow('<b>'.$e->name.'</b>',$e->start->format('m/d/y'));
    }
    $added = Member::getMember($row['owner']);
    $issueTable->addRow($row['first'].' '.$row['last'],$added->getLink(),$row['yog'],$row['reason']);
}
$status->setContent($issueTable);
$page->addBox($status,'double');

$list = new Box('list',"Blacklist");
$table = new BCTable();
$table->header = array("First","Last","YOG","Reason");
$query = new Query("SELECT * FROM  `blacklist` ORDER BY  `lastname` DESC ");
while($row = $query->nextRow()){
    $table->addRow($row['firstname'],$row['lastname'],$row['yog'],$row['reason']);
}
$list->setContent($table);
$page->addBox($list,'double');

return $page;
?>