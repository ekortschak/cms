<?php

incCls("input/qikOption.php");
incCls("input/confirm.php");
incCls("menus/dropBox.php");
incCls("editor/QED.php");

$loc = PGE::$dir;

// ***********************************************************
// offer option(s)
// ***********************************************************
$arr = array(
	"doc" => "Document",
	"toc" => "Table of Contents",
);
$dst = array(
	"scr" => "Screen",
	"fil" => "File",
#	"pdf" => "PDF",
);

$box = new dropBox("menu");
$opt = $box->getKey("xsite.opt", $arr);
$mod = $box->getKey("xsite.dst", $dst);
$act = $box->show();

// ***********************************************************
// show info
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/xsite.tpl");
$tpl->show("info");

// ***********************************************************
// show module xsite
// ***********************************************************
# output handled by the module xsite itself

// ***********************************************************
// react to quick edit options
// ***********************************************************
$sel = ENV::getParm("opt.starthere", 0);
$top = ENV::get("xsite.top", TAB_HOME);

if ($sel)
if ($top != $loc) $top = ENV::set("xsite.top", $loc);

$sel = ($top === $loc);

// ***********************************************************
// ask for confirmation
// ***********************************************************
$dst = DIC::get("output.screen"); if ($mod != "scr");
$dst = DIC::get("output.file");
$hed = DIC::get("file.merge");
$tit = PGE::title($top);

$cnf = new confirm();
$cnf->set("link", "?dmode=xsite");
$cnf->head($hed);
$cnf->dic("scope", $tit);
$cnf->add("&rarr; $dst");
$cnf->show();

// ***********************************************************
// offer quick edit options
// ***********************************************************
HTW::xtag("qik.edit");

$qik = new qikOption();
$qik->forget();
$qik->getVal("opt.starthere", $sel);
$qik->show();

?>
