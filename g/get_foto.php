<?
$name = $QUERY_STRING;
if ( !file_exists("ei_pics/".$name.".dat") ) exit;
$type = implode('',file("ei_pics/".$name.".dat"));
$name1 = $name.".".$type;
$data = @file("ei_pics/$name1");
if ( !$data ) exit;
$data = implode('',$data);
if ($type=='jpg') $type = 'jpeg';
header("Content-type: image/$type");
die($data);
?>
