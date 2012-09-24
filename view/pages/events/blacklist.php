<?php
$page = new Page('blacklist');


$list = new Box('list',"Blacklist");
$table = new BCTable();
$table->header = array("First","Last","YOG","Reason");
$query = new Query("SELECT * FROM  `blacklist` ORDER BY  `lastname` ASC ");
while($row = $query->nextRow()){
    $table->addRow($row['firstname'],$row['lastname'],$row['yog'],$row['reason']);
}
$list->setContent($table);
$page->addBox($list,'double');

return $page;
?>