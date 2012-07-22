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
if ($pi = $user->getPiNum(true))
	echo "<p>$pi</p>";
?>
	<img src="<?php echo $user->getPhotoPath(); ?>" style="width: 180px">
	<a href="/messages/compose/to:<?php echo $user->id ?>">Send Message</a>
<?php 
$page->setLeft(ob_get_clean());
ob_start();
?>
	<h2>Info</h2>
email: <?php echo $user->email ?><br />
<?php echo isset($user->cell) ? "cell phone: $user->cell<br />" : "";?>
<?php echo isset($user->major) ? "major: $user->major<br />" : "";?>
<?php echo isset($user->schoolloc) ? "school address: $user->schoolloc<br />" : "";?>
home address:<br />
<?php echo isset($user->homeaddr) ? nl2br($user->homeaddr,true) : "unknown";?><br />
year of graduation: <?php echo $user->yog ?><br />
dob: <?php echo $user->dob->format('F jS, Y') ?><br />
<?php
$page->setRight(ob_get_clean());

return $page;
?>