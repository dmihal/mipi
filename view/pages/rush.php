<?php
$user = getUser();
switch (@$_GET[1]) {
	case 'person':
		$page = Page::getPage('rush/person');
		break;
	case 'newphoto':
		$msg = "msg:error";
		if ($_POST['rushee'] && $_FILES['newphoto'] && $rushee = Rushee::getRushee($_POST['rushee'])) {
			$rushee->moveNewPhoto($_FILES['newphoto']['tmp_name']);
			$msg = "msg:newphoto";
		}
		header("Location: /mipi/rush/$msg");
		break;
	default:
		$page = new Page("Rush");
		
		$box = new Box("rush","Rush");
		$peoplelist = new BCPeopleList();
		$peoplelist->defaultState = 'thumbnail';
		$peoplelist->setColumns("Email","Social","Cell Phone","Year");
		$peoplelist->setThumbColumns("Year");
		
		foreach (Rushee::getRusheesFromQuery("SELECT * FROM rushees ") as $rushee) {
			/* @var $rushee Rushee */
			$peoplelist->addPerson($rushee->first, $rushee->last, "rush/person/$rushee->id", $rushee->getPhotoPath(),$rushee->email,'',$rushee->phone,$rushee->getYearName());
		}
		
		//$peoplelist->addPerson("Warren", "Smalle", "user/12345", "",
		//			"abeleveau@wpi.edu",'<a href="http://www.facebook.com/andrew.beliveau">Facebook</a>',"123456789","&#960;1643","2012","June 8, 1989");
		
		$box->setContent($peoplelist);
		$page->addBox($box,'tripple');
		break;
}
$page->section = "rush";
return $page;
?>
