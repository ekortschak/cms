<?php

incCls("editor/iniMgr.php");
incCls("files/iniTab.php");
incCls("menus/topics.php");

// ***********************************************************
$tab = FSO::trim(TAB_ROOT);

$tbs = new tabsets();
$tab = $tbs->verify(TAB_MODE, $tab);

ENV::set("tedit.tab", $tab);

// ***********************************************************
// find tabsets
// ***********************************************************
$ini = new iniTab($tab);
$tit = $ini->getTitle();
$std = $ini->get("props.std");

$tps = new topics();
$std = $tps->verify($tab, $std);

// ***********************************************************
HTW::tag("Tab = $tit");
// ***********************************************************
$ful = FSO::join($tab, "tab.ini");

$mgr = new iniMgr("tab.def");
$mgr->read($ful);
$mgr->edit();

?>
