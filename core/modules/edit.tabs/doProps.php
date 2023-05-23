<?php

incCls("editor/iniMgr.php");
incCls("files/iniTab.php");

// ***********************************************************
$tab = FSO::trim(TAB_ROOT);
$tab = PGE::tabsetsVerify(APP_CALL, $tab);

ENV::set("tedit.tab", $tab);

// ***********************************************************
// find tabsets
// ***********************************************************
$ini = new iniTab($tab);
$tit = $ini->getTitle();
$typ = $ini->getType("root");
$std = $ini->get("props.std");

$arr = PGE::topics();
$std = PGE::topicsVerify($tab, $std);

// ***********************************************************
HTW::tag("Tab = $tit");
// ***********************************************************
$ful = FSO::join($tab, "tab.ini");

$mgr = new iniMgr("tab.def");
$mgr->read($ful);
$mgr->edit();

?>
