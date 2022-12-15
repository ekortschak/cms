<?php

// ***********************************************************
// show available languages / flags
// ***********************************************************
$lgs = "";

foreach (LNG::get() as $lng) {
	$tpl->set("lang", $lng);
	$lgs.= $tpl->gc("lang");
}
$tpl->set("langs", $lgs);
$tpl->show("main");

// ***********************************************************
// login option
// ***********************************************************
if (! DB_CON)   $tpl->clearSec("dbase");
if (! DB_LOGIN) $tpl->clearSec("dblogout");
if (  DB_LOGIN) $tpl->clearSec("dblogin");

// ***********************************************************
// show basic nav
// ***********************************************************
if (! $cfg->get("uopts.print")) $tpl->clearSec("print");
if (! $cfg->get("uopts.csv"))   $tpl->clearSec("csv");
if (! $cfg->get("uopts.man"))   $tpl->clearSec("manual");

if (  $cfg->get("uopts.login")) {
	if (DB_LOGIN) $tpl->substitute("user", "logout");
	else          $tpl->substitute("user", "login");
}

$tpl->show("nav");

?>
