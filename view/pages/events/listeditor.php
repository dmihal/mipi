<?php
if(!($eventID=@$_GET[2]))
{
	header("Location: /mipi/events/msg:enf");
	exit;
}
$eventList=new GuestList($eventID);
//var_dump($eventList);
$page = new Page("List Editor");

$editbox = new Box('listform',"Edit List");
$form = new BCStatic();
ob_start();
?><form action="/mipi/events/listsave/">
	Male 1: <input name="m1f" /><input name="m1l" /><br />
	Male 2: <input name="m2f" /><input name="m2l" /><br />
	Female 1: <input name="f1f" /><input name="f1l" /><br />
	Female 2: <input name="f2f" /><input name="f2l" /><br />
	Female 3: <input name="f3f" /><input name="f3l" /><br />
	Female 4: <input name="f4f" /><input name="f4l" /><br />
	Female 5: <input name="f5f" /><input name="f5l" /><br />
	<input type="hidden" name="event" value="<?php echo $eventID ?>" />
	<button type="submit">Save</button>
</form><?php
$form->content= ob_get_clean();
$editbox->setContent($form);
$page->addBox($editbox,'left');

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
