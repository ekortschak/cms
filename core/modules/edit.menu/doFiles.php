<?php

incCls("input/qikOption.php");
incCls("menus/dropBox.php");
incCls("files/dirView.php");

// ***********************************************************
// get options
// ***********************************************************
$qik = new qikOption();
$xxx = $qik->getVal("opt.overwrite", 0);
$ovr = $qik->gc();

// ***********************************************************
// prepare sys files
// ***********************************************************
$fls = array(
	"banner"  => "banner",
	"head"    => "head",
	"page"    => "page",
	"help"    => "help",
	"tail"    => "tail",
	"trailer" => "trailer",
);
$lgs = array(
	CUR_LANG  => CUR_LANG,
	"xx"      => "xx",
);
$ext = array(
	"htm"     => "htm",
	"php"     => "php",
);

// ***********************************************************
// show sys file boxes
// ***********************************************************
$box = new dropBox();
$box->hideDesc();
$box->getKey("sys.file", $fls, "page");
$box->getKey("sys.lang", $lgs, "xx");
$box->getKey("sys.ext",  $ext);

$drp = $box->gc();

// ***********************************************************
// show list
// ***********************************************************
$tpl = new dirView();
$tpl->load("editor/menu.files.tpl");
$tpl->set("choice", $drp);
$tpl->set("curloc", CUR_PAGE);
$tpl->set("visOnly", false);
$tpl->set("overwrite", $ovr);
$tpl->readTree(CUR_PAGE);
$tpl->show();

?>

