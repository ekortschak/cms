<?php

#incCls("editor/iniMgr.php");

// ***********************************************************
// add and drop tabs
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/menu.tab.tpl");
$tpl->register();
$tpl->show("drop");

#$mgr = new iniMgr(false);
#$mgr->read("config/tabsets.ini");
#$mgr->edit();

?>
