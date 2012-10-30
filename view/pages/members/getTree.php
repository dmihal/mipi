<?php
$page = new Page('');
$page->raw = true;

$tree = Member::buildTree();

$newtree = array("name"=>"Pi Colony","children"=>convertTree($tree));
$page->rawData = json_encode($newtree);
return $page;

function convertTree($tree)
{
    $newtree = array();
	foreach ($tree as $ID => $subtree) {
        $person = Member::getMember($ID);
		$node = array("name"=>$person->getName());
        if($subtree){
            $node['children'] = convertTree($subtree);
        }
        $newtree[] = $node;
	}
    return $newtree;
}
?>