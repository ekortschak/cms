
<?php

$mot = CFG::getConst("PRJ_MOTTO", "");

// ***********************************************************
// show banner
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/app.banner.tpl");
$tpl->set("title", $mot);

$tpl->show();

?>
