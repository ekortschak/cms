<?php

incCls("editor/iniMgr.php");
incCls("files/iniTab.php");

// ***********************************************************
// find tabsets
// ***********************************************************
$ini = new iniTab(TAB_HOME);
$tit = $ini->title();
$std = $ini->get("props.std");

// ***********************************************************
HTW::tag("Tab = $tit");
// ***********************************************************
$ful = FSO::join(TAB_HOME, "tab.ini");

$mgr = new iniMgr("tab.def");
$mgr->read($ful);
$mgr->edit();

?>
