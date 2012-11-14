<?php
$page = new Page("Bids");

$box = new Box("bids","Rushees with Bids");
try{
    $peoplelist = new BCPeopleList('bids');
    $peoplelist->defaultState = 'thumbnail';
    $peoplelist->setColumns("Email","Social","Cell Phone","Year");
    $peoplelist->setThumbColumns("Year");
    
    foreach (Rushee::getRusheesFromQuery("SELECT * FROM rushees WHERE `bid`='TRUE' ORDER BY `last`") as $rushee) {
        /* @var $rushee Rushee */
        $peoplelist->addPerson($rushee->first, $rushee->last, "/rush/person/$rushee->id", $rushee->getPhotoPath(),$rushee->email,$rushee->getFBLink().'<br />'.$rushee->getTwitterLink(),$rushee->phone,$rushee->getYearName());
    }
    
    $box->setContent($peoplelist);
} catch (Exception $e){
    $box->setContent(new BCStatic("No Bids Given!"));
}
$page->addBox($box,'tripple');

return $page;
?>