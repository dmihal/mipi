<?php
if(!($eventID=@$_GET[2]))
{
	return Page::getPage('events/listoflists');
}
if(@$_GET[3]=='print'){
	return Page::getPage('events/listprint');
} elseif(@$_GET[3]=='excel'){
    return Page::getPage('events/excel');
}

$user = getUser();
$eventList=new GuestList($eventID);
$myGuests = array_key_exists(intval($user->id), $eventList->guestsByOwner) ? $eventList->guestsByOwner[$user->id] : array();
$maxguests = $eventList->getGuestsAllowed();
$numMyGuests = count($myGuests);
$page = new Page("List Editor");

if(@$_GET['msg']=='updated'){
    $page->message = "List Updated!";
}

$disabled = $eventList->listOpen() ? "" : ' disabled="disabled"';

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
function addGuest(first,last,sex,link){
    if (spots<availableSpots){
        ++spots;
        $("#remain").html(availableSpots-spots);
        $("#guestFields").append('<li>'+ sex +'<input type="hidden" name="sex[]" value="'+ sex +'" /> - <input name="first[]" value="'+first+'" /> <input name="last[]" value="'+last+'" /></li>');
        link.parentNode.removeChild(link);
    }
    return false;
}
<?php
$page->js = ob_get_clean();

$linkbox = new Box("links","");
$linkcontent = new BCStatic();
ob_start();
?>
<a href="/events/list/<?php echo $eventID ?>/print">Print</a><br />
<a href="/events/description/<?php echo $eventID ?>">Event Information</a>
<?php
$linkcontent->content = ob_get_clean();
$linkbox->setContent($linkcontent);
$page->addBox($linkbox);

$edit = new Box("edit","Edit List");
ob_start();
if ($eventList->listOpen()){
    echo '<form method="POST" action="/events/update" >';
}
?>
    <input type="hidden" name="event" value="<?php echo $eventID ?>" />
<?php
if ($eventList->listOpen()) {
	echo '<div>You have <span id="remain">';
	echo ($maxguests-$numMyGuests) . '</span> spots remaining</div>';
    if($eventList->listUnlocks){
        echo '<div>All spots unlock on '. $eventList->listUnlocks->format('F jS \a\t h:i A') .'</div>';
    }
    if ($eventList->listCloses) {
        echo '<div>The list will close on '.$eventList->listCloses->format('F jS \a\t h:i A') .'</div>';
    }
} else {
	echo '<div>This guest list is closed</div>';
}
?>
    <ol id="guestFields">
<?php
for ($i=0; $i< intval(count(@$myGuests)); $i++) {
	$guest = $myGuests[$i];
    /* @var $guest Person */
   echo '<li>' . $guest->getSex().'<input type="hidden" name="sex[]" value="'.$guest->sex.'" /> - ';
   echo '<input name="first[]" value="'.$guest->first.'"'.$disabled.' /> ';
   echo '<input name="last[]" value="'.$guest->last.'"'.$disabled.' /></li>';
}
?>
    </ol>

<?php
if ($eventList->listOpen()){
    ?>
    <div><a href="#" onclick="return newEntry('Guy')" >Add Guy</a> | <a href="#" onclick="return newEntry('Girl')" >Add Girl</a></div>
    <button>Save</button>
</form>
    <?php
}
$edit->setContent(new BCStatic(ob_get_clean()));
$page->addBox($edit);

if ($eventList->listOpen()){
    $frequentbox = new Box('frequent','Frequent Guests');
    ob_start();
    $frequents = array_diff(GuestList::getFrequentGuests(getUser()), $myGuests);
    foreach ($frequents as $person) {
        $gender = $person->sex == Person::FEMALE ? 'Girl' : 'Guy';
        echo '<a style="display:block" href="#" onclick="return addGuest(\''.$person->first.'\',\''.$person->last.'\',\''.$gender.'\',this)" >'.$person->getName().'</a>';
    }
    $frequentbox->setContent(new BCStatic(ob_get_clean()));
    $page->addBox($frequentbox);
}

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

$view = new Box('listbox',"Guest List for ".$eventList->event->name);
$table = new BCTable();
$table->header = array("Guest","Sex","Member");
foreach ($eventList->guests as $value) {
	$member = Member::getMember($value['owner']);
    $guest = $value['guest'];
    $table->addRow($guest->getName(),$guest->getSex(),$member->getLink());
}
$view->setContent($table);
$page->addBox($view,'double');

return $page;

?>
