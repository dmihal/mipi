<?php
$page = new Page("Family Tree");
$page->section = "members";

$box = new Box("tree","Family Tree");
$box->setContent(new BCTree());
$page->addBox($box,'tripple');


return $page;
?>