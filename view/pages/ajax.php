<?php
$page = new Page("");
$page->raw = true;

ob_start();
switch ($_GET[1]) {
	case 'membertoken':
        $q = $_GET['q'];
        $members = Member::getMembersFromQuery("SELECT * FROM users WHERE nameFirst LIKE '$q%' OR nameLast LIKE '$q%' ORDER BY nameLast;");
        $suggest = array();
        foreach ($members as $member) {
            /* @var $member Member */
           $suggest[] = array("id"=>$member->id,"name"=>$member->getName());
        }
		echo json_encode($suggest);
		break;
    case 'shout':
        if (array_key_exists('message', $_POST)) {
            Shout::newShout($_POST['message']);
            echo 'true';
        }
        break;
    case 'vote':
        $dir = "";
        if (strcasecmp($_POST['dir'], 'UP') == 0) {
            $dir = "UP";
        } elseif(strcasecmp($_POST['dir'], 'DOWN') == 0) {
            $dir = "DOWN";
        } else {
            exit;
        }
        $user = getUser();
        $rusheeID = $_POST['id'];
        
        Query::insert("INSERT INTO `rush_votes`  (`user`,`rushee`,`vote`) VALUES ('$user->id', '$rusheeID', '$dir')
  ON DUPLICATE KEY UPDATE `vote`='$dir';");
        break;
	default:
		
		break;
}
$page->rawData = ob_get_clean();

return $page;
?>