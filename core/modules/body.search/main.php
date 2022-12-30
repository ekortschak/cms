<?php

$fnd = ENV::get("search");
$fil = ENV::get("prv");
$tpc = ENV::get("dir");

$arr = ENV::get("last.search");
$dat = VEC::get($arr, $tpc);
$tit = VEC::get($dat, $fil);

$dir = dirname($fil);
$uid = HTM::pgeProp($dir, "props.uid", $fil);

$rut = dirname($tpc);
$dir = STR::after($dir, "$rut/");

// ***********************************************************
// preview searched item
// ***********************************************************
incCls("search/swrap.php");

$obj = new swrap();
$txt = $obj->getSnips($fil, $fnd);

$tpl = new tpl();
$tpl->read("design/templates/modules/search.tpl");

if (! $txt) {
	$tpl->show("none");
	return;
}

$tpl->set("topic", $tpc);
$tpl->set("title", $tit);
$tpl->set("dir", $dir);
$tpl->set("page", $uid);
$tpl->show("nav.preview");

// ***********************************************************
// text
// ***********************************************************
$txt = STR::mark($txt, $fnd);
echo $txt;

?>
