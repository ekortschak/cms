<?php

DBG::file(__FILE__);

// ***********************************************************
// show banner
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/banner.tpl");
$tpl->set("title", CFG::constant("PRJ_MOTTO", ""));
$tpl->show();

?>
