<?php
$page = new Page("Compose Message");

$reply;
try {
    $reply = Message::getMessage(@$_GET['r']);
} catch (Exception $e) {
    $reply = null;
}
$to = (isset($_GET['to'])) ? Member::getMember($_GET['to']) : null;

ob_start();
$tolkenSetings = "";
if ($reply){
    echo "var to = ";
    $recipients = $reply->getRecipients(true);
    $jsonarray = array();
    for ($i=0; $i < count($recipients); $i++) { 
        if ($recipients[$i]==getUser()) {
            unset($recipients[$i]);
        } else {
            $jsonarray[] = array("id"=>$recipients[$i]->id, "name"=>$recipients[$i]->getName());
        }
        
    }
    echo json_encode($jsonarray).";";
    $tolkenSetings = ",prePopulate:to,disabled:true";
} elseif($to) {
    echo "var to = [{id:$to->id,name:\"".$to->getName()."\"}]";
    $tolkenSetings = ",prePopulate:to";
}
?>

$(function(){
    $("#tofield").tokenInput("/ajax/membertoken",{theme:'facebook'<?php echo $tolkenSetings; ?>});
});
<?php
$page->js = ob_get_clean();

$box = new Box('composer','Compose Message');
ob_start();

$rSubj = $reply ? 'disabled="true" value="'.$reply->subject.'" ' : "";
?>
<form method="post" action="/messages/send">
    <label>To: <input id="tofield" name="to" /></label><br />
    <label>Subject: <input name="subject" <?php echo $rSubj ?>/></label><br />
    <label>Confidential: <input type="checkbox" name="confidential" /></label><br />
    <textarea name="message" style="width: 600px;height: 200px;"></textarea><br />
    <button>Send</button>
</form>

<?php
$box->setContent(new BCStatic(ob_get_clean()));
$page->addBox($box,'tripple');

return $page;
?>