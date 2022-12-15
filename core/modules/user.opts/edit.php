<?php

switch (APP_CALL) {
	case "config.php": return $tpl->show("config");
	case "index.php":  break;
	default: return;
}

// ***********************************************************
$edt = false;
$edt = ($edt || $cfg->get("eopts.pedit"));
$edt = ($edt || $cfg->get("eopts.medit"));

dbg($cfg->getValues());

if (! $edt) return;

// ***********************************************************
// editing
// ***********************************************************
if (is_file("x.edit.php")) {
	if (! $cfg->get("eopts.pedit")) $tpl->clearSec("pedit");
	if (! $cfg->get("eopts.xedit")) $tpl->clearSec("xedit");
	if (! $cfg->get("eopts.medit")) $tpl->clearSec("medit");
	if (! $cfg->get("eopts.seo"))   $tpl->clearSec("seo");

	if (IS_LOCAL) {
		if (! $cfg->get("eopts.xfer") ) $tpl->clearSec("xfer" );
		if (! $cfg->get("eopts.debug")) $tpl->clearSec("debug");
	}
	$tpl->show("edit");
}

// ***********************************************************
// setup
// ***********************************************************
if (is_file("config.php")) {
	if (! $cfg->get("setup.show")) $tpl->clearSec("admin");
	if (! $cfg->get("setup.edit")) $tpl->clearSec("pedit");
	$tpl->show("admin");
}

?>
