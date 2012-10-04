<?php
$user = getUser();
switch (@$_GET[1]) {
    case 'add':
        $page = Page::getPage('rush/add');
        break;
    case 'addnew':
        $rushee = Rushee::addNew($_POST['name_f'], $_POST['name_l'], $_POST['email'],getUser());
        $rushee->phone = $_POST['phone'];
        $rushee->yog = $_POST['yog'];
        $rushee->fbid = $_POST['fbid'];
        $rushee->twitid= $_POST['twitid'];
        $rushee->brother = $_POST['brother'];
        $rushee->location = $_POST['location'];
        $rushee->room = $_POST['room'];
        $rushee->major = $_POST['major'];
        if ($_FILES['photo'] && file_exists($_FILES['photo']['tmp_name'])){
            $rushee->moveNewPhoto($_FILES['photo']['tmp_name']);
        }
        $rushee->save();
        header("Location: /mipi/rush/msg:added");
        break;
	case 'person':
		$page = Page::getPage('rush/person');
		break;
	case 'newphoto':
		$msg = "msg:error";
		if ($_POST['rushee'] && $_FILES['newphoto'] && $rushee = Rushee::getRushee($_POST['rushee'])) {
			$rushee->moveNewPhoto($_FILES['newphoto']['tmp_name']);
			$msg = "msg:newphoto";
		}
		header("Location: /rush/$msg");
		break;
    case 'comment':
        if ($_POST['rushee']) {
            Comment::addComment($_POST['rushee'], getUser(), 'RUSHEE', $_POST['comment']);
            echo "comment added";
            exit;
        }
        break;
	default:
		$page = new Page("Rush");
		
        if(@$_GET['msg']=='added'){
            $page->message = "Rushee added";
        }
        
		$box = new Box("rush","Rush");
		$peoplelist = new BCPeopleList();
		$peoplelist->defaultState = 'thumbnail';
		$peoplelist->setColumns("Email","Social","Cell Phone","Year");
		$peoplelist->setThumbColumns("Year");
		
		foreach (Rushee::getRusheesFromQuery("SELECT * FROM rushees ") as $rushee) {
			/* @var $rushee Rushee */
			$peoplelist->addPerson($rushee->first, $rushee->last, "/rush/person/$rushee->id", $rushee->getPhotoPath(),$rushee->email,'',$rushee->phone,$rushee->getYearName());
		}
		
		$box->setContent($peoplelist);
		$page->addBox($box,'tripple');
		break;
}
$page->section = "rush";
return $page;
?>
