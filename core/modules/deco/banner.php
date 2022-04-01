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
#if (! $cfg->get("deco.search")) $tpl->setSec("search");
if (! $cfg->get("deco.print"))  $tpl->setSec("print");
if (! $cfg->get("deco.csv"))    $tpl->setSec("csv");

$tpl->show("nav");

?>
