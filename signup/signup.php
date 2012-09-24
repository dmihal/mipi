<?php
chdir('../');
function __autoload($name) {
    $filename = strtolower($name).".class.php";
    if(is_file("model/$filename"))
        include_once("model/$filename");
}
require_once 'control/query.class.php';
/*$username   = validatePost('username',FILTER_VALIDATE_REGEXP, array('regexp'=>"/^[A-Za-z0-9]$/") );
$password   = validatePost('password',FILTER_VALIDATE_REGEXP, array('regexp'=>"*."));
$namef      = validatePost('name_f',FILTER_VALIDATE_REGEXP, array('regexp'=>"[A-Za-z -]") );
$namel      = validatePost('name_l',FILTER_VALIDATE_REGEXP, array('regexp'=>"[A-Za-z -]") );*/
$pi         = validatePost('pi',FILTER_VALIDATE_INT);
$yog        = validatePost('yog',FILTER_VALIDATE_INT);
$email      = validatePost('email',FILTER_VALIDATE_EMAIL);
//$phone      = validatePost('phone', FILTER_VALIDATE_REGEXP, array('regexp'=>"\(?(\d{3})\)?-?(\d{3})-(\d{4})"));

$member = Member::newMember($_POST['username'], $_POST['password'],'BROTHER');
$member->first      = $_POST['name_f'];
$member->last       = $_POST['name_l'];
$member->yog        = $yog;
$member->email      = $email;
$member->cell       = $_POST['phone'];
$member->dob        = new DateTime($_POST['dob']);
$member->schoolloc  = mysql_escape_string($_POST['schoolloc']);
$member->homeaddr   = mysql_escape_string($_POST['homeaddr']);
$member->major      = mysql_escape_string($_POST['major']);
$member->fbid       = mysql_escape_string($_POST['fbid']);
$member->twitid     = mysql_escape_string($_POST['twitid']);
if ($member instanceof Brother){
    $member->setPi($pi);
}
$member->moveNewPhoto($_FILES["photo"]["tmp_name"]);
$member->save();

function validatePost($name,$type,$options=NULL)
{
    print_r($options);
    $filtered = filter_var($_POST[$name],$type,array('options'=>$options));
    if (!$filtered){
        throw new Exception("Error with field $name", 1);
    }
    return $filtered;
}
?>
<!doctype html>
<html>
    <body>
        <p>You might have created an account, or it might have failed. <a href="/login.php">Click Here</a> to try to log in</p>
    </body>
</html>