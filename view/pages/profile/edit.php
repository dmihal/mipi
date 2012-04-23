<?php
$page = new Page("Edit Profile");
$user = getUser();

$left = new Box("left",$user->getName());
$leftContent = new BCStatic();
ob_start();
?>
<form action="/mipi/profile/picsave" method="post" enctype="multipart/form-data">
	<img src="<?php echo $user->getPhotoPath() ?>" style="width: 200px" />
	<input type="file" name="profpic" /><br />
	<button type="submit">Update Photo</button>
</form>

<?php
$leftContent->content = ob_get_clean();
$left->setContent($leftContent);
$page->addBox($left,'left');

$mainForm = new Box("main","Edit Profile");
$formContent = new BCStatic();
ob_start();
?>
<form action="/mipi/profile/save" method="post">
	<label>Email: <input name="email" type="email" value="<?php echo $user->email ?>" /></label><br />
	<label>Cell Phone: <input name="cell" type="tel" /></label><br />
	<button type="submit">Save</button>
</form>

<?php
$formContent->content = ob_get_clean();
$mainForm->setContent($formContent);
$page->addBox($mainForm,'double');

$page->section = "profile";
return $page;
?>