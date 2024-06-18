<?php

DBG::file(__FILE__);

// ***********************************************************
incCls("server/upload.php");
incCls("input/selector.php");
incCls("input/ptracker.php");
incCls("input/qikOption.php");

// ***********************************************************
// read properties
// ***********************************************************
$ext = CFG::get("upload:props_upl.ext", "*");
$max = CFG::get("upload:props_upl.max_size", 2000);
$ovr = CFG::get("upload:props_upl.overwrite", 0);
$dst = CFG::get("upload:props_upl.path", PGE::$dir);

HTW::tag("dir = $dst", "hint");

// ***********************************************************
// react to previous commands
// ***********************************************************
$ptk = new ptracker();
$act = $ptk->watch("act", "OK");

if ($act) {
	$upl = new upload();
	$upl->maxFiles(5);
	$upl->maxSize($max);
	$upl->overwrite(ENV::getPost("opt_overwrite", $ovr));
	$upl->moveAllFiles($dst);
}

// ***********************************************************
HTW::xtag("settings");
// ***********************************************************
$sel = new selector(); // just for information
$sel->disable();
$ext = $sel->ronly("upl.types", $ext);
$cnt = $sel->ronly("upl.count", 5);
$max = $sel->ronly("upl.size", $max);
$xxx = $sel->setProp("info", "KB");
$act = $sel->show();

// ***********************************************************
// show form
// ***********************************************************
REG::add("LOC_SCR/upload.js");

$sel = new selector();
$sel->setHeader(DIC::get("upl.upload"));
$sel->hide("dest", $dst);
$sel->set("ext", $ext);
$sel->set("max", $max * 1000);
$sel->upload("upl.files");
$sel->show();

// ***********************************************************
// get options
// ***********************************************************
$qik = new qikOption();
$qik->getVal("opt.overwrite", 0);
$qik->show();

?>
