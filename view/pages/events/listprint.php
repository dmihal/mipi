<?php
$page = new Page("Printable list");
$page->raw = true;
$eventList=new GuestList($_GET[2]);

ob_start();
?>
<table>
	<tr>
		<th>Guest</th>
		<th>Brother</th>
		<th>Pi</th>
	</tr>

<?php
while($guest = $eventList->getCurrentGuest())
{
	$owner = $eventList->getCurrentOwner();
    
    $pi = ($owner->type == Member::BROTHER or $owner->type == Member::ALUMNI) ? $owner->getPiNum(true) : "AM";
	
	echo '<tr><td>'.$guest->getName(true).'</td><td>'.$owner->getName().'</td><td>'.$pi.'</td></tr>';
	
	$eventList->advance();
}
?>
</table>
<?php
$page->rawData = ob_get_clean();

return $page;
?>