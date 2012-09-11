<?php
$page = new Page("Add Rushee");
$page->setForm("/rush/addnew",'POST',true);

$box = new Box('formbox','Add Rushee');
ob_start();
?>
<label>First Name:<input name='name_f' /></label><br />
<label>Last Name:<input name='name_l' /></label><br />
<br />
<label>Email: <input name="email" type="email" /></label><br />
<label>Phone: <input name="phone" type="tel" /></label><br />
<br />
<label>YOG: <input name="yog" type="number" min="<?php echo date('Y') ?>" max="<?php echo date('Y')+4 ?>" value="<?php echo date('Y')+3 ?>" /></label><br />
<br />
<label>Photo: <input name="photo" type="file" accept="image/jpeg" /></label><br />
<br />
<button type="submit">Add</button>
<?php
$box->setContent(new BCStatic(ob_get_clean()));
$page->addBox($box,'tripple');

return $page;
?>