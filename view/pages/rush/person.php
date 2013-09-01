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

try{
    $comments = $user->getComments();
} catch(Exception $e){
    $comments = array();
}
$numComments = count($comments);

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
    <ul class="nav nav-tabs" style="margin-bottom: 10px;">
        <li><a href= "#tabs-1" data-toggle="tab">Info</a></li>
        <li><a href= "#tabs-2" data-toggle="tab">Edit</a></li>
        <?php if(getUser()->type!=Member::AM){?><li><a href= "#tabs-3" data-toggle="tab" onclick="cmtRead(<?php echo $user->id ?>)">Comments<?php echo $numComments ? " ($numComments)" : '' ?></a></li><?php } ?>
        <li><a href="#tabs-4" data-toggle="tab">Attendance</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="tabs-1">
            email: <?php echo $user->email ?><br />
            phone: <?php echo $user->phone;?><br />
            major: <?php echo $user->fieldString('major') ?><br />
            school address: <?php echo $user->fieldString('location') ?><br />
            room: <?php echo $user->fieldString('room'); ?><br />
            home address:<br />
            year of graduation: <?php echo $user->yog ?><br />
            dob: <?php echo $user->dob->format('F jS, Y') ?><br />
            assigned brother: <?php echo $user->getBrother() ? $user->getBrother()->getLink() : '';?><br />
            campus involvement: <?php echo $user->fieldString('involvement'); ?><br />
            <br />
            <?php echo $user->getFBLink() ?><br />
            <?php echo $user->getTwitterLink() ?>
            
        </div>
        <div class="tab-pane" id="tabs-2">
            <form action="/rush/saverushee" method="post">
                <label>Bid? <input type="checkbox" name="bid" <?php echo $user->bid ? "checked" :"" ?> /></label>
                <button type="submit">Save</button>
            </form>
        </div>
        <?php if(getUser()->type!=Member::AM){?><div class="tab-pane" id="tabs-3">
            <form id="postComment" onsubmit="addComment(this);return false;">
                <textarea name="comment"></textarea><input type="hidden" name="rushee" value="<?php echo $user->id ?>" />
                <button type="submit">Post</button>
            </form>
            <ul class="comments">
    <?php
    try {
        foreach ($comments as $comment){
            /* @var $comment Comment */
            echo '<li><div class="lcol">'.$comment->getOwner()->getLink().'<br />'.$comment->date->format('m/d/Y h:i').'</div><div>'.$comment->message."</div><br style=\"clear:both\"/></li>";
        }
    } catch(Exception $e){
        echo "No comments!";
    }
    ?>
            </ul>
        </div><?php } ?>
        <div class="tab-pane" id="tabs-4"></div>
    </div>
</div>

<?php
$page->setRight(ob_get_clean());

return $page;
?>