<?php

DBG::file(__FILE__);

// ***********************************************************
$fil = "modules/user.opts.tpl"; if ((SEARCH_BOT) || (VMODE == "joker"))
$fil = "modules/searchbot.tpl";

$tpl = new tpl();
$tpl->load($fil);

// ***********************************************************
// show available languages / flags
// ***********************************************************
$lgs = "";

foreach (LNG::get() as $lng) {
	if ($lng == CUR_LANG) continue;
	$tpl->set("lang", $lng);
	$lgs.= $tpl->gc("lang");
}

// ***********************************************************
// show basic nav
// ***********************************************************
if (! CFG::mod("setup.show")) $tpl->clearSec("config");
if (! CFG::mod("uopts.man"))  $tpl->clearSec("manual");

if (  CFG::mod("uopts.login")) {
	if (DB_LOGIN) $tpl->substitute("user", "logout");
	else          $tpl->substitute("user", "login");
}

if (! $lgs)
$tpl->substitute("langs", "no.langs");

$tpl->set("langs", $lgs);
$tpl->show("nav");

?>
