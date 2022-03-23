<?php

switch (APP_CALL) {
	case "config.php": return $tpl->show("view");
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
	if (! $cfg->get("$qid.medit")) $tpl->setSec("medit");
	if (! $cfg->get("$qid.xform")) $tpl->setSec("xform"); // localhost only
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

// ***********************************************************
// one click options
// ***********************************************************
if (! is_file("x.edit.php")) return;

incCls("menus/qikLink.php");

echo "<p>";
$qik = new qikLink();
$qik->getVal("opt.tooltip", 0);
$qik->show();
echo "</p>";

?>
