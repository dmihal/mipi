<?php
$page = new Page("Compose Message");

ob_start();
?>
$(function(){
    $("#tofield").tokenInput("/mipi/ajax/membertoken",{theme:'facebook'});
});
<?php
$page->js = ob_get_clean();

$box = new Box('composer','Compose Message');
ob_start();
?>
<label>To: <input id="tofield" name="to" /></label><input name="toid" id="toid" type="hidden" /><br />
<label>Confidential: <input type="checkbox" name="confidential" /></label><br />
<textarea name="message" style="width: 99%;height: 400px;"></textarea><br />
<button>Send</button>
<?php
$box->setContent(new BCStatic(ob_get_clean()));
$page->addBox($box,'tripple');

return $page;
?>