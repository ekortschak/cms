<?php

incCls("server/upload.php");
incCls("input/selector.php");
incCls("input/ptracker.php");
incCls("input/qikOption.php");

// ***********************************************************
// read properties
// ***********************************************************
$ext = CFG::getVal("upload:props.ext", "*");
$max = CFG::getVal("upload:props.max_size", 2000);
$ovr = CFG::getVal("upload:props.overwrite", 0);
$dst = CFG::getVal("upload:props.path", PGE::$dir);

HTW::tag("dir = $dst", "hint");

// ***********************************************************
// react to previous commands
// ***********************************************************
$ptk = new ptracker();
$act = $ptk->watch("act", "OK");

if ($act) {
	$upl = new upload();
	$upl->setMaxFiles(5);
	$upl->setMaxSize($max);
	$upl->setOverwrite(ENV::getPost("opt_overwrite", $ovr));
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
REG::add("js", "LOC_SCR/upload.js");

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
