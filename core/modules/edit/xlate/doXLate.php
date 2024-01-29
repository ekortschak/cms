<?php

$act = ENV::getPost("act_xlate");
$src = APP::snip(PGE::$dir);

incCls("editor/xlate.php");
incCls("other/strProtect.php");

// ***********************************************************
// setting options
// ***********************************************************
$xlc = new xlate();
$xlc->setHead("text.xlate");
$xlc->setLang();
$xlc->setDest($src);

if (! $xlc->act()) return;

// ***********************************************************
// acting on selected file
// ***********************************************************
$htm = $xlc->read($src);
$sec = "main";

if ($act) {
	$sec = "done";
	$htm = ENV::getPost("content");
	$xxx = $xlc->save($htm);
}

// ***********************************************************
// show output
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/edit.xdic.tpl");
$tpl->set("content", $htm);
$tpl->show($sec);

?>
