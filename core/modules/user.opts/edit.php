<?php

$edt = false;
$edt = ($edt || CFG::mod("eopts.pedit"));
$edt = ($edt || CFG::mod("eopts.medit"));

if (! $edt) return;

// ***********************************************************
// prevent non sensical icons
// ***********************************************************
if (! is_file("config.php")) {
	$tpl->clearSec("admin");
}
if (! is_file("x.edit.php")) {
	$tpl->clearSec("edit");
	$tpl->clearSec("xfer");
}
if (! is_file("x.sync.php")) {
	$tpl->clearSec("xfer");
}
if (! is_file("debug.php")) {
	$tpl->clearSec("debug");
}

if (! IS_LOCAL) {
	$tpl->clearSec("debug");
}
if (APP_NAME != "cms") {
	$tpl->clearSec("config.cms");
}

// ***********************************************************
switch (APP_CALL) {
	case "config.php": return $tpl->show("config");
	case "index.php":  break;
	default: return;
}

// ***********************************************************
// editing
// ***********************************************************
if (! CFG::mod("eopts.pedit")) $tpl->clearSec("pedit");
if (! CFG::mod("eopts.xedit")) $tpl->clearSec("xedit");
if (! CFG::mod("eopts.medit")) $tpl->clearSec("medit");
if (! CFG::mod("eopts.seo"))   $tpl->clearSec("seo");
if (! CFG::mod("eopts.xfer"))  $tpl->clearSec("xfer");
if (! CFG::mod("eopts.debug")) $tpl->clearSec("debug");

$tpl->show("edit");

// ***********************************************************
// setup
// ***********************************************************
if (! CFG::mod("setup.show")) $tpl->clearSec("admin");
if (! CFG::mod("setup.edit")) $tpl->clearSec("pedit");

$tpl->show("admin");

?>
