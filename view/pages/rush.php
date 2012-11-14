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
        $rushee->involvement = $_POST['involvement'];
        if ($_FILES['photo'] && file_exists($_FILES['photo']['tmp_name'])){
            $rushee->moveNewPhoto($_FILES['photo']['tmp_name']);
        }
        if (intval($_POST['brother'])){
            Rushee::setVote($_POST['brother'], $rushee->id, 'UP');
        }
        $rushee->save();
        header("Location: /rush/msg:added");
        break;
	case 'person':
		$page = Page::getPage('rush/person');
		break;
    case 'votes':
        $page = Page::getPage('rush/votes');
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
    case 'bids':
    	$page = Page::getPage('rush/bids');
    	break;
    case 'stats':
        $page = Page::getPage('rush/stats');
        break;
	default:
		$page = new Page("Rush");
		
        if(@$_GET['msg']=='added'){
            $page->message = "Rushee added";
        }
        
		$box = new Box("rush","Rush");
        try{
    		$peoplelist = new BCPeopleList('rushees');
    		$peoplelist->defaultState = 'thumbnail';
    		$peoplelist->setColumns("Involvement","Email","Social","Cell Phone","Year","Comments");
    		$peoplelist->setThumbColumns("Year");
    		
    		foreach (Rushee::getRusheesFromQuery("SELECT *,(SELECT count(*) FROM `comments` WHERE subject=rushees.ID) as comments FROM rushees WHERE `bid`='FALSE' ORDER BY `last`") as $rushee) {
    			/* @var $rushee Rushee */
    			$peoplelist->addPerson($rushee->first, $rushee->last, "/rush/person/$rushee->id", $rushee->getPhotoPath(),$rushee->fieldString('involvement'),$rushee->email,$rushee->getFBLink().'<br />'.$rushee->getTwitterLink(),$rushee->phone,$rushee->getYearName(),$rushee->comments);
    		}
    		
    		$box->setContent($peoplelist);
		} catch (Exception $e){
		    $box->setContent(new BCStatic("No Rushees!"));
		}
		$page->addBox($box,'tripple');
		break;
}
$page->section = "rush";
return $page;
?>
