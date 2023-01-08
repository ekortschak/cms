<?php

$loc = PFS::getLoc();

// ***********************************************************
$ini = new ini();
$ext = $ini->get("props.ext", "pdf, txt, doc, docx");
$dox = $ini->get("props.path", $loc);
$srt = $ini->get("props.sort");
$exc = $ini->getType("inc");

// ***********************************************************
incCls("files/dirView.php");
// ***********************************************************
$obj = new dirView();
$obj->load("modules/fview.download.tpl");
$obj->setSort($srt);
$obj->readTree($dox, $ext);
$obj->show();

?>
