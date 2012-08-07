<?php
$page = new Page('Message Popup');
$page->raw = true;

$message;
try {
    $message = Message::getMessage($_GET[2]);
} catch (Exception $e) {
    $page->rawData = "Could not load message";
    return $page;
}
/* @var $message Message */

ob_start();
?>
<div style="background-color: #FFF2D3">
    <button onclick="reply(<?php echo $message->id ?>)">Reply All</button>
    <button onclick="unread(<?php echo $message->id ?>,this)">Mark Unread</button>
</div>
<div style="width: 600px;">
    <div style="float: left;background: #E5E5E5;padding: 5px;margin: 5px;">
        <img src="<?php echo $message->getSender()->getPhotoPath() ?>" style="width:200px;" /><br />
        <?php echo $message->getSender()->getLink(); ?><br />
        <?php echo $message->getSender()->getPiNum(); ?>
    </div>
    <?php echo $message->message ?>
</div>
<?php
while ($last = $message->getReplied())
{
    echo $last->message . "<br />";
}

$page->rawData = ob_get_clean();
$message->setRead();

return $page;
?>