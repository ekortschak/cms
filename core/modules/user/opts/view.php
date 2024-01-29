<?php

DBG::file(__FILE__);

// ***********************************************************
$fil = "modules/user.opts.tpl"; if (SEARCH_BOT)
$fil = "modules/searchbot.tpl";

$tpl = new tpl();
$tpl->load($fil);

// ***********************************************************
// check opts
// ***********************************************************
if (! CFG::mod("uopts.pres"))  $tpl->clearSec("pres");
if (! CFG::mod("uopts.csv"))   $tpl->clearSec("csv");
if (! CFG::mod("uopts.print")) $tpl->clearSec("print");

$ok1 = (TAB_SET != "default");
$ok2 = (VMODE != "view");

if ($ok1 || $ok2) {
	$tpl->clearSec("pres");
	$tpl->clearSec("csv");
	$tpl->clearSec("print");
}

// ***********************************************************
// show opts
// ***********************************************************
$tpl->show("view");

?>
