<?php
/**
 * 
 */
class BCPeopleList implements BoxContent {
	
	public $people;
	public $columns;
	public $defaultState = 'table';
	
	function __construct() {
		
	}
	
	function getHTML()
	{
		ob_start();
?>
<div id="peopleSetings">
	<a href="#" onclick="peoplestate='thumbnail';buildList();return false;">Thumbnail View</a> - <a href="#" onclick="peoplestate='table';buildList();return false;">Table View</a>
</div>
<div id="list">
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

window.peoplelist = <?php echo $this->getPeopleJSON(); ?>;
window.peoplestate = "<?php echo $this->defaultState; ?>";
function buildList()
{
	var div = $("#list");
	div.html("");
	if (peoplestate == 'thumbnail')
	{
		for(var i in peoplelist.people)
		{
			var person = peoplelist.people[i];
			div.append('<div class="personBox"><div style="height:175px"><img src="'+person.img+'" /></div>' +
			"<h3><a href=\""+person.url+"\" class=\"userlink\">"+person.first+" "+person.last+"</a></h3>");
		}
	} else if (peoplestate == 'table')
	{
		var headings = "";
		for(var column in peoplelist.columns)
		{
			headings += "<th>"+column+"</th>";
		}
		div.append('<table id="persontable"><thead><tr><th>Photo</th><th>Name</th>'+headings+'</tr></thead><tbody></tbody></table>');
		var tbody = $("#persontable tbody");
		for(var i in peoplelist.people)
		{
			var person = peoplelist.people[i];
			var values = "";
			for(var n in person.values)
			{
				values += "<td>"+person.values[n]+"</td>";
			}
			tbody.append('<tr><td><img src="'+person.img+'" style="width:75px;"/></td><td><a href= "'+person.url+'" class=\"userlink\">'+person.first+' '+person.last+'</a></td>'+values+'</tr>')
		}
	}
	$("#list a.userlink").fancybox({onComplete:fbLoaded});
}
$(buildList);

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