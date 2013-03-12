<?php
$page = new Page("Change Password");

if(array_key_exists('msg', $_GET) and $_GET['msg']=='pwer'){
    $page->setMessage("Incorrect password");
}

$box = new Box("pw","Change Password");
ob_start();
?>
<label>Old Password: <input type="password" name="oldpw" /></label><br />
<label>Old Password: <input type="password" name="oldpw2" /></label><br />
<label>New Password: <input type="password" name="newpw"/></label><br />
<button type="submit">Change</button>
<?php
$box->setContent(new BCStatic(ob_get_clean()));
$page->addBox($box,'tripple');
$page->setForm('/profile/setpw');

return $page;
?>