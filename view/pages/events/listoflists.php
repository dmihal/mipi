<?php
$page = new Page("Guest Lists");

$open = new Box("open","Open Lists");
$page->addBox($open,'double');

$closed = new Box("closed","Closed Lists");
$page->addBox($closed,'right');

return $page;
?>