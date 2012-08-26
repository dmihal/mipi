<?php
$user = Member::getMember($_GET[1]);

$page = new Page('User Info');
$page->raw = true;
ob_start();
echo '<pre>';
var_dump($user);
echo '</pre>';
$page->rawData = ob_get_clean();
return $page
?>