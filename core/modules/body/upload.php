<?php

incCls("server/upload.php");
incCls("input/selector.php");
incCls("input/qikOption.php");

// ***********************************************************
// read properties
// ***********************************************************
$ini = new ini("config/upload.ini");
$ext = $ini->get("props.ext", "*");
$max = $ini->get("props.max_size", 2000);
$ovr = $ini->get("props.overwrite", 0);
$dst = $ini->get("props.path", CUR_PAGE);

// ***********************************************************
// react to previous commands
// ***********************************************************
$ptk = new ptracker();
$act = $ptk->watch("act", "OK");

if ($act) {
	$upl = new upload();
	$upl->setOverwrite(ENV::getPost("opt_overwrite", $ovr));
	$upl->moveAllFiles($dst);
	$upl->setMaxFiles(5);
	$upl->setMaxSize($max);
}

// ***********************************************************
HTW::xtag("settings");
// ***********************************************************
$sel = new selector(); // just for information
$dst = $sel->ronly("upl.dest", $dst);
$ext = $sel->ronly("upl.types", $ext);
$cnt = $sel->ronly("upl.count", 5);
$max = $sel->ronly("upl.size", $max);
$xxx = $sel->setProp("info", "KB");
$act = $sel->show();

// ***********************************************************
// get options
// ***********************************************************
$qik = new qikOption();
$qik->getVal("opt.overwrite", 0);
$qik->show();

// ***********************************************************
HTW::xtag("upl.upload");
// ***********************************************************
REG::add("js", "LOC_SCR/upload.js");

$sel = new selector();
$sel->hidden("dest", $dst);
$sel->set("ext", $ext);
$sel->set("max", $max * 1000);
$sel->upload("upl.files");
$sel->show();

?>
