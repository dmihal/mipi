<?php
$page = new Page("Phonebook");

$phonebook = new Box("inbox","Inbox");
$list = new BCStatic();
ob_start();
?>
<div style="column-count: 3;-webkit-column-count: 3;-webkit-column-rule:solid 1px #999; list-style: none;">
	<li>
		<div style="float: right">8603010022</div>
		<a href="#" class="userlink">David Mihal</a>
	</li>
	<li>
		<div style="float: right">8603010022</div>
		<a href="#" class="userlink">David Mihal</a>
	</li>
	<li>
		<div style="float: right">8603010022</div>
		<a href="#" class="userlink">David Mihal</a>
	</li>
</div>
<?php
$list->content = ob_get_clean();
$phonebook->setContent($list);
$page->addBox($phonebook,'tripple');

$page->section = "message";
return $page;
?>