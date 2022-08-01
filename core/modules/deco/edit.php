<?php

switch (APP_CALL) {
	case "config.php": return $tpl->show("config");
	case "x.edit.php": break;
	case "index.php":  break;
	default: return;
}

// ***********************************************************
$qid = "deco"; if (! IS_LOCAL)
$qid = "online";

$edt = false;
$edt = ($edt || $cfg->get("$qid.pedit"));
$edt = ($edt || $cfg->get("$qid.medit"));

if (! $edt) return;

// ***********************************************************
// editing
// ***********************************************************
if (is_file("x.edit.php")) {
	if (! $cfg->get("$qid.pedit")) $tpl->setSec("pedit");
	if (! $cfg->get("$qid.xedit")) $tpl->setSec("xedit");
	if (! $cfg->get("$qid.medit")) $tpl->setSec("medit");
	if (! $cfg->get("$qid.xfer") ) $tpl->setSec("xfer" ); // localhost only
	if (! $cfg->get("$qid.debug")) $tpl->setSec("debug"); // localhost only
	$tpl->show("edit");
}

// ***********************************************************
// setup
// ***********************************************************
if (is_file("config.php")) {
	if (! IS_LOCAL) $tpl->substitute("admin", "admin.web");
	if (! $cfg->get("setup.show")) $tpl->setSec("admin");
	if (! $cfg->get("setup.edit")) $tpl->setSec("xedit");
	$tpl->show("admin");
}

?>
