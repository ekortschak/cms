<?php

$ext = PGE::get("props.ext", "pdf, txt, doc, docx");
$dox = PGE::get("props.path", CUR_PAGE);
$srt = PGE::get("props.sort");

// ***********************************************************
incCls("files/dirView.php");
// ***********************************************************
$obj = new dirView();
$obj->load("modules/fview.download.tpl");
$obj->setSort($srt);
$obj->readTree($dox, $ext);
$obj->show();

?>
