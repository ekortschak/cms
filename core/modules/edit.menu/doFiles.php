<?php

// ***********************************************************
// get options
// ***********************************************************
incCls("menus/qikLink.php");

$qik = new qikLink();
$xxx = $qik->getVal("opt.overwrite", 0);
$ovr = $qik->gc();

// ***********************************************************
// prepare sys files
// ***********************************************************
$fls = array(
	"banner"  => "Banner",
	"head"    => "Head",
	"page"    => "Content",
	"help"    => "Help",
	"tail"    => "Tail",
	"trailer" => "Trailer",
);
$lgs = array(
	CUR_LANG  => CUR_LANG,
	"xx"      => "xx",
);
$ext = array(
	"htm"     => "htm",
	"php"     => "php",
);

incCls("menus/dropBox.php");

$box = new dropBox();
$box->hideDesc();
$box->getKey("sys.file", $fls, "page");
$box->getKey("sys.lang", $lgs, "xx");
$box->getKey("sys.ext",  $ext);

$drp = $box->gc();

// ***********************************************************
// show list
// ***********************************************************
incCls("files/dirView.php");

$tpl = new dirView();
$tpl->load("editor/menu.files.tpl");
$tpl->set("choice", $drp);
$tpl->set("curloc", CUR_PAGE);
$tpl->set("visOnly", false);
$tpl->set("overwrite", $ovr);
$tpl->readTree(CUR_PAGE);
$tpl->show();

?>

