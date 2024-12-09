<?php

DBG::file(__FILE__);

// ***********************************************************
// load banner
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/banner.tpl");
$tpl->set("title", CFG::constant("PRJ_MOTTO", ""));

$arr = glob("img/logo.*");

if (! $arr) {
	$tpl->clearSec("logo");
}
else {
	$ext = FSO::ext($arr[0]);
	$tpl->set("ext", $ext);
}

// ***********************************************************
// show banner
// ***********************************************************
$tpl->show();

?>
