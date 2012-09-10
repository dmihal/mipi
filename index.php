<?php 

require "control/session.class.php";
include("control/query.class.php");
include 'control/sqlquerybuiler.class.php';
include("control/ChromePhp.php");
function __autoload($name) {
	$filename = strtolower($name).".class.php";
	if(is_file("view/$filename"))
    	include_once("view/$filename");
	elseif(is_file("model/$filename"))
		include_once("model/$filename");
}

////////////// Session Block ////////////////
/* Initiate session variables
 * Log in user if logging in
 * Redirect user to login if not logged in
 */
session_start();
if(!isset($_SESSION['obj']) || !is_object($_SESSION['obj']))
{
	if (isset($_POST['user']) && isset($_POST['password'])) {
		try 
		{
			$_SESSION['obj'] = new Session(Member::getMemberLogin($_POST['user'], $_POST['password']));
		}
		catch (Exception $e)
		{
			header("Location: /login.php");
			exit;
		}
	} else {
		header("Location: /login.php");
		exit;
	}
}
$session = $_SESSION['obj'];
ChromePhp::log($session);
/**
 * undocumented function
 *
 * @return Member
 */
function getUser() {
	return $_SESSION['obj']->user;
}

@$requestRaw = $_GET['request'];
$_GET = array_merge(explode('/', $requestRaw),$_GET);
foreach ($_GET as $value) {
	if(($pos = strpos($value,':'))!==false)
	{
		$key = substr($value,0,$pos);
		$val = substr($value,$pos+1);
		$_GET[$key] = $val;
	}
}
unset($requestRaw);
$_GET[0] = ($_GET[0]=="") ? "home" : $_GET[0];
ChromePhp::log($_GET);


//try{
	$doc = new Template(Page::getPage($_GET[0]));
	$html = $doc->buildPage();
/*}
catch (Exception $e)
{
	$html = "Error: 404";
	header("HTTP/1.0 404 Not Found");
}*/

echo $html;
//echo preg_replace('/href="(\/)?/', 'href="/mipi/', $html);
session_write_close(); 
?>