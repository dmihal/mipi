<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class BCCalendar implements BoxContent {
	
	public $events;
	public $year, $month;
	
	public function __construct($month=NULL,$year=NULL)
	{
		$this->month	= (is_null($month)) ? date('m') : $month;
		$this->year		= (is_null($year))	? date('Y') : $year;
	}
	public function addEvent($name,$link,$day,$time=NULL,$month=NULL,$year=NULL)
	{
		$month	= (is_null($month)) ? date('m') : $month;
		$year	= (is_null($year))	? date('Y') : $year;
		$date = new DateTime("$month/$day/$year $time");
		
		$this->events[$year][$month][$day][] = array("name"=>$name, "link"=>$link, "date"=>$date, "time"=>$time);
	}
	
	public function getHTML()
	{
		$first_day = strtotime($this->month.'/01/'.$this->year.' 00:00:00');
		$blanks = (int) date('w',$first_day);
		$days = (int) date('t',$first_day);
		
		ob_start();
?>
<h3><?php echo date('F', $first_day); ?></h3>
<table>
	<thead>
		<tr>
			<th style="width:14.28571%">Sunday</th>
			<th style="width:14.28571%">Monday</th>
			<th style="width:14.28571%">Tuesday</th>
			<th style="width:14.28571%">Wednesday</th>
			<th style="width:14.28571%">Thursday</th>
			<th style="width:14.28571%">Friday</th>
			<th style="width:14.28571%">Saturday</th>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php
$week = $blanks;
if($blanks>0)
{
	echo "<td colspan=\"$blanks\" style=\"border:none\" >&nbsp;</td>";
}
for($day = 1;$day<=$days;$day++)
{
	$links = "";
	if(isset($this->events[$this->year][$this->month][$day])){
		foreach ($this->events[$this->year][$this->month][$day] as $value) {
			$links .= '<a href="'.$value['link'].'">'.$value["name"].'</a>';
		}
	}
	echo "<td>$day<br />$links</td>";
	if(++$week >= 7)
	{
		echo "</tr><tr>";
		$week = 0;
	}
	
}
?>
		</tr>
	</tbody>
</table>
<?php
		return ob_get_clean();
	}
	public function getJS()
	{
		
	}
} // END
?>