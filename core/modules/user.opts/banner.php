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
if (! VEC::get($cfg, "uopts.print")) $tpl->clearSec("print");
if (! VEC::get($cfg, "uopts.csv"))   $tpl->clearSec("csv");
if (! VEC::get($cfg, "uopts.man"))   $tpl->clearSec("manual");

if (  VEC::get($cfg, "uopts.login")) {
	if (DB_LOGIN) $tpl->substitute("user", "logout");
	else          $tpl->substitute("user", "login");
}

$tpl->show("nav");

?>
