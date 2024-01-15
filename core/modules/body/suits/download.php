<?php

DBG::file(__FILE__);

// ***********************************************************
$ext = PGE::get("props_dow.ext", "pdf, txt, doc, docx");
$dox = PGE::get("props_dow.path", PGE::$dir);
$srt = PGE::get("props_dow.sort");

// ***********************************************************
incCls("files/dirView.php");
// ***********************************************************
$obj = new dirView();
$obj->load("modules/fview.download.tpl");
$obj->setSort($srt);
$obj->readTree($dox, $ext);
$obj->show();

?>
