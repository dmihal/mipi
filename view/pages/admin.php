<?php
$page;
if (isset($_GET['officer'])){
    $page = Page::getPage('admin/officerAdmin');
} else {
    $page = Page::getPage("admin/".$_GET[1]);
}
$page->section = "profile";

return $page;

?>