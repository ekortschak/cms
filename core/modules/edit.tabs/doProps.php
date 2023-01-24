<?php

incCls("menus/tabs.php");
incCls("menus/dropBox.php");
incCls("editor/iniMgr.php");
incCls("files/iniTab.php");

// ***********************************************************
$set = APP_CALL;
$tab = trim(TAB_ROOT, "/");

$tbs = new tabset();
$tab = $tbs->verify($set, $tab);

ENV::set("tedit.tab", $tab);

// ***********************************************************
// find tabsets
// ***********************************************************
$ini = new iniTab($tab);
$tit = $ini->getTitle();
$typ = $ini->get("props.typ", "root");
$std = $ini->get("props.std");

$tbs = new tabs();
$tps = $tbs->getTypes("select");
$arr = $tbs->getTopics($tab);
$std = $tbs->verify($tab, $std);

// ***********************************************************
HTW::tag("Tab = $tit");
// ***********************************************************
$ful = FSO::join($tab, "tab.ini");

$ini = new iniMgr("LOC_CFG/tab.def");
$ini->exec($ful);
$ini->setChoice("props.typ", $tps, $typ);
$ini->setChoice("props.std", $arr, $std);
$ini->show();

?>
