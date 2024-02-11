<?php

DBG::file(__FILE__);

// ***********************************************************
// get results
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/search.tpl");
$tpl->show("intro");
$tpl->show("info");
$tpl->show("info.text");
$tpl->show("extro");

?>
