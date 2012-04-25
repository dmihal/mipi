<?php
$page = new PopupSplit();

$user;
try{
	$user = Member::getMember($_GET[1]);
} catch (Exception $e) {
	//$page->rawData = '<script type="application/javascript">$.fancybox.close();</script>';
	$page->rawData = 'The user could not be found<br /><a href="#" onclick="$.fancybox.close()">Close</a>';
	return $page;
}

ob_start();

?>
	<h1><?php echo $user->getName(); ?></h1>
<?php
if ($pi = $user->getPiNum())
	echo'<p>$pi</p>';
?>
	<img src="<?php echo $user->getPhotoPath(); ?>" style="width: 180px">
	<a href="#">Send Message</a>
<?php 
$page->setLeft(ob_get_clean());
ob_start();
?>
	<h2>Info</h2>
email: <?php echo $user->email ?><br />
<?php echo isset($user->cell) ? "cell phone: $user->cell<br />" : "";?>
major: Computer Science<br />
school address: Morgan 412<br />
home address:<br />
367 Eastbury Hill Rd<br />
Glastonbury, CT 06033<br />
year of graduation: 2015<br />
dob: November, 13 2012<br />
<?php
$page->setRight(ob_get_clean());

return $page;
?>