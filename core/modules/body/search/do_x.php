<?php

DBG::file(__FILE__);

// ***********************************************************
// no results
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/search.tpl");
$tpl->show("err.empty");

?>
