<?php

DBG::file(__FILE__);

// ***********************************************************
$mot = CFG::constant("PRJ_MOTTO", "&nbsp;");

// ***********************************************************
// show banner
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/banner.tpl");
$tpl->set("title", $mot);

$tpl->show();

?>
