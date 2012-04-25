<?
	if(@mysql_connect("localhost","root",""))
	{
		mysql_select_db("mypi");
	}
	else
	{
		throw new Exception("Could not connect to database");
	}
?>
