<?php
$page = new Page("Add Rushee");
$page->setForm("/rush/addnew",'POST',true);

ob_start();
?>

$(function() {
    $("#brother").tokenInput("/ajax/membertoken",{theme:'facebook',prepopulate:[{id:<?php echo getUser()->id ?>,name:"<?php echo getUser()->getName() ?>"}]});
});
<?php
$page->js = ob_get_clean();

$box = new Box('formbox','Add Rushee');
ob_start();
?>
<label>First Name:<input name='name_f' /></label><br />
<label>Last Name:<input name='name_l' /></label><br />
<br />
<label>Email: <input name="email" type="email" /></label><br />
<label>Phone: <input name="phone" type="tel" /></label><br />
<label>Facebook Username: <input name="fbid" id="fbid" onchange="document.getElementById('fbpic').style.background = 'url(http://graph.facebook.com/'+ this.value +'/picture)';" /></label>
<div id="fbpic" style="height: 50px;width: 50px;display:inline-block;vertical-align: bottom;background:gray;">&nbsp;</div><br />
<label>Twitter Name: @<input name="twitid" id="twitid" onchange="document.getElementById('twitpic').style.background = 'url(https://api.twitter.com/1/users/profile_image?screen_name='+ this.value +')';" /></label>
<div id="twitpic" style="height:48px;width:48px;display:inline-block;vertical-align: bottom;background:gray;">&nbsp;</div><br />
<br/>
<br />
<label>YOG: <input name="yog" type="number" min="<?php echo date('Y') ?>" max="<?php echo date('Y')+4 ?>" value="<?php echo date('Y')+3 ?>" /></label><br />
<label>Major: <input name="major" list="majors" /></label><br />
<datalist id="majors">
    <option value="Mechanical Engineering"/>
    <option value="Biology"/>
    <option value="Robotics"/>
    <option value="Biomedical Engineering"/>
    <option value="ECE"/>
    <option value="Computer Science"/>
    <option value="Civil Engineering"/>
</datalist>   
<label>Location: <input name="location" list="locations"></label><br />
<datalist id="locations">
    <option value="Morgan Hall"/>
    <option value="Daniels Hall"/>
    <option value="Riley Hall"/>
    <option value="Stoddard A"/>
    <option value="Stoddard B"/>
    <option value="Stoddard C"/>
    <option value="Institute Hall"/>
    <option value="Founders Hall"/>
</datalist>    
<label>Room: <input name="room" /></label>
<br />
<label>Brother Assigned: <input name="brother" id="brother" /></label>
<br />
<br />
<label>Photo: <input name="photo" type="file" accept="image/jpeg" /></label><br />
<br />
<button type="submit">Add</button>
<?php
$box->setContent(new BCStatic(ob_get_clean()));
$page->addBox($box,'tripple');

return $page;
?>