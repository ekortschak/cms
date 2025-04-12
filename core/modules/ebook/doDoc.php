<?php

incCls("input/qikOption.php");
incCls("input/confirm.php");
incCls("menus/dropBox.php");
incCls("editor/QED.php");

$loc = PGE::$dir;
ENV::set("ebook.opt", "doc");

// ***********************************************************
// show info
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/ebook.tpl");
$tpl->show("info");

// ***********************************************************
// show module ebook
// ***********************************************************
# output handled by the module ebook itself

// ***********************************************************
// react to quick edit options
// ***********************************************************
$sel = ENV::getParm("opt.starthere", 0);
$top = ENV::get("ebook.top", TAB_HOME);

if ($sel)
if ($top != $loc) $top = ENV::set("ebook.top", $loc);

$sel = ($top === $loc);

// ***********************************************************
// ask for confirmation
// ***********************************************************
$dst = DIC::get("output.screen"); if ($mod != "scr")
$dst = DIC::get("output.file");
$hed = DIC::get("file.merge");
$tit = PGE::title($top);

$cnf = new confirm();
$cnf->set("link", "?dmode=vbook");
$cnf->head($hed);
$cnf->dic("scope", $tit);
$cnf->add("&rarr; Erstelle Dokument");
$cnf->add("&rarr; Screen");
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
