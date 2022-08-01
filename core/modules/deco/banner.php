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
if (! DB_CON)   $tpl->setSec("dbase");
if (! DB_LOGIN) $tpl->setSec("dblogout");
if (  DB_LOGIN) $tpl->setSec("dblogin");

// ***********************************************************
// show basic nav
// ***********************************************************
if (! $cfg->get("deco.manual")) $tpl->setSec("manual");
if (! $cfg->get("deco.print"))  $tpl->setSec("print");
if (! $cfg->get("deco.csv"))    $tpl->setSec("csv");

if (! $cfg->get("deco.login"))  $tpl->setSec("login");
if (DB_LOGIN) $tpl->copy("logout", "login");

$tpl->show("nav");

?>
