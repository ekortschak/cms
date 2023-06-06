<?php

$mot = CFG::getConst("PRJ_MOTTO", "&nbsp;");

// ***********************************************************
// show banner
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/banner.tpl");
$tpl->set("title", $mot);

$tpl->show();

?>
