<?php 
$page = new PopupSplit();

$user;
try{
	$user = Rushee::getRushee($_GET[2]);
} catch (Exception $e) {
	//$page->rawData = '<script type="application/javascript">$.fancybox.close();</script>';
	$page->rawData = 'The user could not be found<br /><a href="#" onclick="$.fancybox.close()">Close</a>';
	return $page;
}

ob_start();

?>
	<h1><?php echo $user->getName(); ?></h1>
	<img src="<?php echo $user->getPhotoPath(); ?>" style="width: 180px">
	<form method="post" action="/rush/newphoto" enctype="multipart/form-data">
		<label>New Photo: <input type="file" name="newphoto" /></label>
		<input type="hidden" name="rushee" value="<?php echo $user->id ?>" />
		<button type="submit">Upload</button>
	</form>
<?php 
$page->setLeft(ob_get_clean());
ob_start();
?>
<div class="tabs" style="width:400px;">
    <div style="float:left;margin-bottom: 10px;">
    <ul>
        <li><a href= "#tabs-1">Info</a></li>
        <li><a href= "#tabs-2">Edit</a></li>
        <li><a href= "#tabs-3">Comments</a></li>
        <li><a href= "#tabs-4">Attendance</a></li>
    </ul>
    </div>
    <div id="tabs-1">
        email: <?php echo $user->email ?><br />
        <?php echo $user->fieldString('cell');?>
        major: <?php echo $user->fieldString('major') ?><br />
        school address: <?php echo $user->fieldString('location') ?><br />
        room: <?php echo $user->fieldString('room'); ?><br />
        home address:<br />
        year of graduation: <?php echo $user->yog ?><br />
        dob: <?php echo $user->dob->format('F jS, Y') ?><br />
        assigned brother: <?php //echo $user->getBrother()->getName() ?><br />
        
    </div>
    <div id="tabs-2">
        <form>
            <label></label>
        </form>
    </div>
    <div id="tabs-3">
        <form id="postComment" onsubmit="addComment(this);return false;">
            <textarea name="comment"></textarea><input type="hidden" name="rushee" value="<?php echo $user->id ?>" />
            <button type="submit">Post</button>
        </form>
        <ul class="comments">
<?php
try {
    foreach ($user->getComments() as $comment){
        /* @var $comment Comment */
        echo "<li><div>".$comment->getOwner()->getLink().'<br />'.$comment->date->format('F j, Y, g:i a')."</div>".$comment->message."</li>";
    }
} catch(Exception $e){
    echo "No comments!";
}
?>
        </ul>
    </div>
    <div id="tabs-4"></div>
</div>

<?php
$page->setRight(ob_get_clean());

return $page;
?>