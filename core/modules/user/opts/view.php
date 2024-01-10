<?php

DBG::file(__FILE__);

// ***********************************************************
$fil = "modules/user.opts.tpl"; if (SEARCH_BOT)
$fil = "modules/searchbot.tpl";

$tpl = new tpl();
$tpl->load($fil);

// ***********************************************************
// viewing
// ***********************************************************
if (! CFG::mod("uopts.pres"))  $tpl->clearSec("pres");
if (! CFG::mod("uopts.csv"))   $tpl->clearSec("csv");
if (! CFG::mod("uopts.print")) $tpl->clearSec("print");

if (TAB_SET != "default") $tpl->clearSec("print");

// ***********************************************************
$tpl->show("view");

?>
