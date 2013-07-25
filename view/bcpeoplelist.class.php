<?php
/**
 * 
 */
class BCPeopleList implements BoxContent {
	
	public $people;
	public $columns;
	public $defaultState = 'table';
    private $name;
    private $states;
	
	function __construct($name='pplList') {
		$this->name = $name;
        $this->states = (array_key_exists($name,$_COOKIE) and $_COOKIE[$name]=='table') ? array("display:none","") : array("","display:none");
	}
	
	function getHTML()
	{
		ob_start();
?>
<div id="peopleSetings">
	<a href="#" onclick="setList('thumbnail');return false;">Thumbnail View</a> - <a href="#" onclick="setList('table');return false;">Table View</a>
</div>
<div id="list">
</div>
<div id="pplThumb" style="<?php echo $this->states[0] ?>">
<?php
foreach ($this->people as $person) {
	echo '<div class="personBox"><div style="height:175px"><img src="'.$person['img'].'" /></div>';
    echo '<h3><a href="'.$person['url'].'" class="userlink">'.$person['first']." ".$person['last']."</a></h3></div>";
}
?>
</div>
<div id="pplTable" style="<?php echo $this->states[1] ?>">
    <table id="persontable" class="table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
<?php
foreach ($this->columns as $value => $x) {
	echo "<th>$value</th>";
}
?>
            </tr>
        </thead>
        <tbody>
<?php
foreach ($this->people as $person) {
    echo "<tr>";
    echo '<td><img src="'.$person['img'].'" style="width:75px;"/></td>';
    echo '<td><a href="'.$person['url'].'" class="userlink">'.$person['first'].' '.$person['last'].'</a></td>';
	foreach ($person['values'] as $value) {
		echo "<td>$value</td>";
	}
    echo "</tr>";
}
?>
        </tbody>
    </table>
</div>
<div style="clear: both">&nbsp;</div>
<?php
		return ob_get_clean();
	}
	function getJS()
	{
		ob_start();
//<script type="text/javascript">
?>
function setList(state){
    $.cookie('<?php echo $this->name ?>',state);
    if('table'==state){
        $("#pplTable").show();
        $("#pplThumb").hide();
    } else {
        $("#pplTable").hide();
        $("#pplThumb").show();
    }
}

<?php
		return ob_get_clean();
	}
	function getPeopleJSON()
	{
		return json_encode(array(
			"columns"	=> $this->columns,
			"people"	=> $this->people
			));
	}
	function addPerson($first,$last,$url,$img)
	{
		$values = array_slice(func_get_args(),4);
		$this->people[] = array(
			"first"	=> $first,
			"last"	=> $last,
			"url"	=> $url,
			"img"	=> $img,
			"values"=> $values
			);
	}
	function setColumns()
	{
		$this->columns = array_fill_keys(func_get_args(),false);
	}
	function setThumbColumns()
	{
		foreach (func_get_args() as $value) {
			$this->columns[$value] = true;
		}
	}
}

?>