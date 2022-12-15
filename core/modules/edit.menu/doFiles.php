<?php

$loc = PFS::getLoc();
$loc = APP::dir($loc);

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
	"content" => "Content",
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

incCls("menus/dropbox.php");

$box = new dbox();
$box->getKey("sys.file", $fls, "content");
$box->getKey("sys.lang", $lgs, "xx");
$box->getKey("sys.ext",  $ext);

$drp = $box->gc("inline");

// ***********************************************************
// show list
// ***********************************************************
incCls("files/dirView.php");

$tpl = new dirView();
$tpl->read("design/templates/editor/mnuFiles.tpl");
$tpl->set("choice", $drp);
$tpl->set("curloc", $loc);
$tpl->set("visOnly", false);
$tpl->set("overwrite", $ovr);
$tpl->readTree($loc);
$tpl->show();

?>
