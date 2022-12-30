<?php

$act = ENV::getPost("act_xlate");
$loc = PFS::getLoc();
$src = APP::find($loc);

incCls("editor/xlate.php");
incCls("editor/xlator.php");

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
$xlt = new xlator();
$htm = $xlt->getTags($src);
$sec = "main";

if ($act) {
	$sec = "done";
	$rep = ENV::getPost("content");

	$htm = $xlt->getRepText($rep); if (! $dbg)
	$xxx = $xlc->save($htm);
}

// ***********************************************************
// show output
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/genEdit.xdic.tpl");
$tpl->set("content", $htm);
$tpl->show($sec);

?>

