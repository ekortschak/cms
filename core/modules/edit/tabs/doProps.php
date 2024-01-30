<?php

incCls("editor/iniMgr.php");
incCls("files/iniTab.php");

// ***********************************************************
$tab = FSO::trim(TAB_ROOT);

ENV::set("tedit.tab", $tab);

// ***********************************************************
// find tabsets
// ***********************************************************
$ini = new iniTab($tab);
$tit = $ini->getTitle();
$std = $ini->get("props.std");

// ***********************************************************
HTW::tag("Tab = $tit");
// ***********************************************************
$ful = FSO::join($tab, "tab.ini");

$mgr = new iniMgr("tab.def");
$mgr->read($ful);
$mgr->edit();

?>
