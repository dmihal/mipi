<?php
$userOfficers = Officer::getOfficersByUser(getUser());
$title;
$summary;
$body;
$officer;
$pageTitle;
$sidebar;
$hidden;
if(isset($_GET['new'])){
    $sidebar = "New Announcement";
    $officer = Officer::getOfficerByName($_GET['new']);
    $title = $pageTitle = "New Announcement";
    $body = $summary = "";
    $hidden = array("type"=>'new',"officer"=>$officer->id);
} else {
    $sidebar = "Modify Announcement";
    $announcement = Announcement::getAnnouncement($_GET[2]);
    $officer = $announcement->getOfficer();
    $title = $announcement->title;
    $summary = "";
    $body = $announcement->body;
    $pageTitle = "Modifying \"$title\"";
    $hidden = array("type"=>'update',"id"=>$announcement->id);
}

$page = new AdminPage($pageTitle,getUser(),array($officer->name));

$sidebar = new Box('sidebar',$sidebar);
ob_start();
?>
<button type="submit">Save</button><br />
<br />
Posting as <?php echo $officer->title ?><br />
<br />
Summary/Preview:</br>
<textarea name="summary"><?php echo $summary ?></textarea>
<?php
$sidebar->setContent(new BCStatic(ob_get_clean()));
$page->addBox($sidebar,'left');

$editorBox = new Box('editBox',"Editor");
ob_start();
?>
<input type="text" name="title" value="<?php echo $title ?>" /><br />
<textarea name="content" style="width: 95%;height: 300px;font-family: sans-serif"><?php echo $body ?></textarea>
<?php
echo array2hidden($hidden);
$editorBox->setContent(new BCStatic(ob_get_clean()));
$page->addBox($editorBox,'double');

$page->setForm("/admin/saveannounce/");

return $page;

function array2hidden(array $values){
    $html = "";
    foreach ($values as $key => $value) {
        $html .= "<input type=\"hidden\" name=\"$key\" value=\"$value\" />";
    }
    return $html;
}
?>