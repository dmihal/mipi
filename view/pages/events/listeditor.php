<?php
if(!($eventID=@$_GET[2]))
{
	return Page::getPage('events/listoflists');
}
if(@$_GET[3]=='print')
{
	return Page::getPage('events/listprint');
}
$user = getUser();
$eventList=new GuestList($eventID);
//var_dump($eventList);
$page = new Page("List Editor");

$linkbox = new Box("links","");
$linkcontent = new BCStatic();
ob_start();
?>
<a href="/events/list/<?php echo $eventID ?>/print">Print</a>
<?php
$linkcontent->content = ob_get_clean();
$linkbox->setContent($linkcontent);
$page->addBox($linkbox);

$editbox = new Box('listform',"Edit List");
$form = new BCStatic();
$myGuests = $eventList->guestsByOwner[$user->id];
ob_start();
?><form action="/events/listsave/" method="post">
	<table><?php
for($i=0; $i<count(@$myGuests['MALE']) || $i<2; $i++)
{
	$guest = @$myGuests['MALE'][$i];
	list($first,$last) = is_object($guest) ? array($guest->first,$guest->last) : array('','');
	echo "<tr><td>Male ";
	echo $i+1 .'</td><td><input name="mf[]" value="'.$first.'" /><input name="ml[]" value="'.$last.'" /></td></tr>';
}
for($i=0; $i<count(@$myGuests['FEMALE']) || $i<5; $i++)
{
	$guest = @$myGuests['FEMALE'][$i];
	list($first,$last) = is_object($guest) ? array($guest->first,$guest->last) : array('','');
	echo "<tr><td>Female ";
	echo $i+1 .'</td><td><input name="ff[]" value="'.$first.'" /><input name="fl[]" value="'.$last.'" /></td></tr>';
}
?>
	</table>
	<input type="hidden" name="event" value="<?php echo $eventID ?>" />
	<button type="submit">Save</button>
</form><?php
$form->content= ob_get_clean();
$editbox->setContent($form);
$page->addBox($editbox,'left');

$bestRbox = new Box('bestrbox',"Best Ratio");
$bestRtable = new BCTable();
$bestRtable->header = array("Name","Guys","Girls","Ratio");
foreach ($eventList->getRatio(GuestList::BEST) as $row) {
	$person = Member::getMember($row['owner']);
	$bestRtable->addRow($person->getName(),$row['male'],$row['female'],$row['ratio']);
}
$bestRbox->setContent($bestRtable);
$page->addBox($bestRbox,'left');

$bestRbox = new Box('bestrbox',"Worst Ratio");
$bestRtable = new BCTable();
$bestRtable->header = array("Name","Guys","Girls","Ratio");
foreach ($eventList->getRatio(GuestList::WORST) as $row) {
	$person = Member::getMember($row['owner']);
	$bestRtable->addRow($person->getName(),$row['male'],$row['female'],$row['ratio']);
}
$bestRbox->setContent($bestRtable);
$page->addBox($bestRbox,'left');

$view = new Box('listbox',"List");
$table = new BCTable();
$table->header = array("Member","Guy 1","Guy 2","Girl 1","Girl 2","Girl 3","Girl 4","Girl 5");
foreach ($eventList->guestsByOwner as $key => $row) {
	$member = Member::getMember($key);
	$m1 = @$row['MALE'][0];
	$m2	= @$row['MALE'][1];
	$f1	= @$row['FEMALE'][0];
	$f2	= @$row['FEMALE'][1];
	$f3	= @$row['FEMALE'][2];
	$f4	= @$row['FEMALE'][3];
	$f5	= @$row['FEMALE'][4];
	$table->addRow('<a href="user/'.$key.'" class="userlink">'.$member->getName(true)."</a>",
							tryName($m1),
							tryName($m2),
							tryName($f1),
							tryName($f2),
							tryName($f3),
							tryName($f4),
							tryName($f5));
}
$table->addRow("Mihal, David","Bond, James","","Perry, Katy","Fox, Meghan");
$view->setContent($table);
$page->addBox($view,'double');

return $page;

function tryName($person)
{
	return is_object($person) ? $person->getName(true) : "";
}
?>
