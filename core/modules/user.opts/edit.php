<?php

switch (APP_CALL) {
	case "config.php": return $tpl->show("config");
	case "index.php":  break;
	default: return;
}

// ***********************************************************
$edt = false;
$edt = ($edt || VEC::get($cfg, "eopts.pedit"));
$edt = ($edt || VEC::get($cfg, "eopts.medit"));

if (! $edt) return;

// ***********************************************************
// editing
// ***********************************************************
if (is_file("x.edit.php")) {
	if (! VEC::get($cfg, "eopts.pedit")) $tpl->clearSec("pedit");
	if (! VEC::get($cfg, "eopts.xedit")) $tpl->clearSec("xedit");
	if (! VEC::get($cfg, "eopts.medit")) $tpl->clearSec("medit");
	if (! VEC::get($cfg, "eopts.seo"))   $tpl->clearSec("seo");
	if (! VEC::get($cfg, "eopts.xfer")) 	$tpl->clearSec("xfer");
	if (! VEC::get($cfg, "eopts.debug")) $tpl->clearSec("debug");

	if (! IS_LOCAL) {
#		$tpl->clearSec("xfer");
		$tpl->clearSec("debug");
	}
	$tpl->show("edit");
}

// ***********************************************************
// setup
// ***********************************************************
if (is_file("config.php")) {
	if (! VEC::get($cfg, "setup.show")) $tpl->clearSec("admin");
	if (! VEC::get($cfg, "setup.edit")) $tpl->clearSec("pedit");
	$tpl->show("admin");
}

?>
