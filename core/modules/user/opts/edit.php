<?php

if (SEARCH_BOT) return;
if (VMODE == "search") return;
if (VMODE == "joker") return;

DBG::file(__FILE__);

// ***********************************************************
$fil = "modules/user.opts.tpl"; if (TAB_SET != "default")
$fil = "modules/cfg.opts.tpl";

$tpl = new tpl();
$tpl->load($fil);

// ***********************************************************
// prevent non sensical icons
// ***********************************************************
if (! IS_LOCAL) {
	$tpl->clearSec("admin");
	$tpl->clearSec("debug");
}

// ***********************************************************
// editing
// ***********************************************************
if (TAB_SET == "config") {
	if (APP_NAME != "cms") $tpl->clearSec("edit");
}
else {
	$edt = false;
	$edt = ($edt || CFG::mod("eopts.pedit"));
	$edt = ($edt || CFG::mod("eopts.medit"));

	if (! $edt) return;

	if (! CFG::mod("eopts.pedit")) $tpl->clearSec("pedit");
	if (! CFG::mod("eopts.xedit")) $tpl->clearSec("xedit");
	if (! CFG::mod("eopts.medit")) $tpl->clearSec("medit");
	if (! CFG::mod("eopts.xlate")) $tpl->clearSec("xlate");
	if (! CFG::mod("eopts.seo"))   $tpl->clearSec("seo");
	if (! CFG::mod("eopts.debug")) $tpl->clearSec("debug");
}
$tpl->show("edit");

// ***********************************************************
// setup
// ***********************************************************
if (! CFG::mod("setup.edit")) $tpl->clearSec("pedit");
if (! CFG::mod("eopts.xfer")) $tpl->clearSec("xfer");

$tpl->show("admin");

?>
