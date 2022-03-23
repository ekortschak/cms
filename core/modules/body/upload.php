<?php

incCls("server/upload.php");
incCls("input/selector.php");

$loc = PFS::getLoc();

// ***********************************************************
// read properties
// ***********************************************************
$ini = new ini();
$ext = $ini->get("props.ext", "*");
$max = $ini->get("props.max_size", 2000);
$ovr = $ini->get("props.overwrite", 0);
$dst = $ini->get("props.path", $loc);

// ***********************************************************
HTM::tag("options");
// ***********************************************************
$sel = new selector();
$dst = $sel->ronly("destination", $dst);
$ext = $sel->ronly("filetypes", ".png,.gif,.jpg");
$cnt = $sel->ronly("maxcnt", 5);
$max = $sel->ronly("maxsize", $max);
$xxx = $sel->setProp("info", "KB");
$sel->show();

// ***********************************************************
// get options
// ***********************************************************
incCls("menus/qikLink.php");

$qik = new qikLink();
$qik->getVal("opt.overwrite", 0);
$qik->show();

// ***********************************************************
HTM::tag("files.upload");
// ***********************************************************
REG::add("js", "core/scripts/upload.js");

$sel = new selector();
$sel->hidden("dest", $dst);
$sel->set("ext", $ext);
$sel->set("max", $max * 1000);
$sel->upload("files");
$sel->show();

?>
