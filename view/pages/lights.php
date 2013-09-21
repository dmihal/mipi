<?php
$page = new Page("Lights");

$page->js = file_get_contents('js/lights.js');

$diagramBox = new Box('lights','Lights');
ob_start();
?>
<div id="status">Connecting...</div>
<canvas id="room" width="300" height="400"></canvas>
<script src="//cdnjs.cloudflare.com/ajax/libs/fabric.js/1.2.0/fabric.all.min.js"></script>
<?php
$diagramBox->setContent(new BCStatic(ob_get_clean()));
$page->addBox($diagramBox,'left');

$controllerBox = new Box('controlls','Controlls');
ob_start();
?>
<div class="btn-group" data-toggle="buttons" id="groups">
    <label class="btn btn-primary">
        <input type="radio" name="options" id="option1" checked="checked" value="selected" /> Selected Lights
    </label>
    <label class="btn btn-primary">
        <input type="radio" name="options" id="option2" value="0"/> All Lights
    </label>
</div>
<div id="colorpresets">
    <button class="btn" style="background:#FDFEFB">Normal</button>
    <button class="btn" style="background:#FFFFFF">White</button>
    <button class="btn" style="background:#FF0000">Red</button>
    <button class="btn" style="background:#00FF00">Green</button>
    <button class="btn" style="background:#0000FF">Blue</button>
    <button class="btn" style="background:#000000" data-state="off">Off</button>
</div>
<?php
$controllerBox->setContent(new BCStatic(ob_get_clean()));
$page->addBox($controllerBox,'double');

return $page;
?>
