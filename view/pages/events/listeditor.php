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
$myGuests = $eventList->guestsByOwner[$user->id];
$maxguests = $eventList->getGuestsAllowed();
$numMyGuests = count($myGuests);
$page = new Page("List Editor");

ob_start();
?>
var availableSpots = <?php echo $maxguests ?>;
var spots = <?php echo $numMyGuests ?>;

function newEntry(sex){
    if (spots<availableSpots){
        ++spots;
        $("#remain").html(availableSpots-spots);
        $("#guestFields").append('<li>'+ sex +'<input type="hidden" name="sex[]" value="'+ sex +'" /> - <input name="first[]" /> <input name="last[]" /></li>');
    }
    return false;
}
<?php
$page->js = ob_get_clean();

$linkbox = new Box("links","");
$linkcontent = new BCStatic();
ob_start();
?>
<a href="/events/list/<?php echo $eventID ?>/print">Print</a>
<?php
$linkcontent->content = ob_get_clean();
$linkbox->setContent($linkcontent);
$page->addBox($linkbox);

$edit = new Box("edit","Edit List");
?>
<form method="POST" action="/events/update" >
    <input type="hidden" name="event" value="<?php echo $eventID ?>" />
    <div>You have <span id="remain"><?php echo $maxguests-$numMyGuests ?></span> spots remaining</div>
    <ol id="guestFields">
<?php
for ($i=0; $i< intval(count(@$myGuests)); $i++) {
	$guest = $myGuests[$i];
    /* @var $guest Person */
   echo '<li>' . $guest->getSex().'<input type="hidden" name="sex[]" value="'.$guest->sex.'" /> - <input name="first[]" value="'.$guest->first.'" /> <input name="last[]" value="'.$guest->last.'" /></li>';
}
?>
    </ol>
    <div><a href="#" onclick="return newEntry('Guy')" >Add Guy</a> | <a href="#" onclick="return newEntry('Girl')" >Add Girl</a></div>
    <button>Save</button>
</form>
<?php
$edit->setContent(new BCStatic(ob_get_clean()));
$page->addBox($edit);

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
$table->header = array("Guest","Sex","Member");
foreach ($eventList->guests as $value) {
	$member = Member::getMember($value['owner']);
    $guest = $value['guest'];
    $table->addRow($guest->getName(),$guest->getSex(),$member->getLink());
}
/*foreach ($eventList->guestsByOwner as $key => $row) {
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
}*/
//$table->addRow("Mihal, David","Bond, James","","Perry, Katy","Fox, Meghan");
$view->setContent($table);
$page->addBox($view,'double');

return $page;

function tryName($person)
{
	return is_object($person) ? $person->getName(true) : "";
}
?>
