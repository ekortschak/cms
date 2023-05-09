<?php

$lgo = APP::file("img/logo.png");
$bnr = APP::file("img/banner.png");

// ***********************************************************
// show banner
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/app.banner.tpl");

if (! $lgo) $tpl->clearSec("logo");
if (! $bnr) $tpl->clearSec("banner");

$tpl->show();

?>
