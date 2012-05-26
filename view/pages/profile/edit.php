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
	<label>Cell Phone: <input name="cell" type="tel" value="<?php echo $user->fieldString('cell') ?>" /></label><br />
	<label>Major: <input name="major" type="text" value="<?php echo $user->fieldString('major') ?>" /></label><br />
	<label>Year of Graduation: <input name="yog" type="number" min="1913" max="<?php echo date('Y')+4 ?>" value="<?php echo $user->yog ?>" /></label><br />
	<label>Date of Birth: <input id="dob" name="dob" type="date" value="<?php echo $user->dob->format('Y-m-d') ?>" /> (YYYY-MM-DD)</label><br />
	<br />
	<label>School Address: <input name="schoolloc" type="text" value="<?php echo $user->fieldString('schoolloc'); ?>" /> 
		(ex. Morgan 412, 85 Salisbury Street)</label><br />
	<label>Home Address:<br /><textarea name="homeaddr"><?php echo $user->fieldString('homeaddr') ?></textarea></label><br />
	<br />
	<button type="submit">Save</button>
</form>

<?php
$formContent->content = ob_get_clean();
$mainForm->setContent($formContent);
$page->addBox($mainForm,'double');

ob_start();
?>
$(function() {
		$( "#dob" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	})
<?php
$page->js = ob_get_clean();

$page->section = "profile";
return $page;
?>