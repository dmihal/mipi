<?php
$file = File::getFile($_GET[1]);

header('Content-type: ');
header('Content-disposition: attachment; filename=' . $file->filename);
$file = file_get_contents($file->localname);
echo $file;
exit;
?>