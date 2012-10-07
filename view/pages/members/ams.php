<?php
$page = new Page("Associate Members");

$box = new Box("alums","Associate Members");
try {
    $peoplelist = new BCPeopleList();
    $peoplelist->defaultState = 'thumbnail';
    $peoplelist->setColumns("Email","Social","Cell Phone","YOG","Birthday");
    
    $membersList = Member::getMembersFromQuery(Member::QueryAllAMs);
        
        foreach ($membersList as $person) {
            /* @var $person Member */ 
            $peoplelist->addPerson($person->first, $person->last, '/user/'.$person->id, $person->getPhotoPath(),
                                $person->email,$person->getFBLink().'<br />'.$person->getTwitterLink(),$person->fieldString('cell'),$person->yog,$person->dob->format("n/j/Y"));
        }
        
    $box->setContent($peoplelist);
} catch (Exception $e){
    $box->setContent(new BCStatic("Theres no AMs!"))
}

$page->addBox($box,'tripple');

return $page;
?>