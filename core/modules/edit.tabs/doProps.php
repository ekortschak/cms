<?php

incCls("menus/tabs.php");
incCls("menus/dropbox.php");
incCls("editor/iniMgr.php");
incCls("files/iniTab.php");

$set = APP_CALL;
$tab = trim(TAB_ROOT, "/");

// ***********************************************************
// find tabsets
// ***********************************************************
$tbs = new tabs();
$arr = $tbs->getTopics($tab);
$tps = $tbs->getTypes("select");

$ini = new iniTab();
$typ = $ini->get("props.typ", "root");
$std = $ini->get("props.std");

$std = TAB_ROOT.$std;

// ***********************************************************
HTM::Tag("Props");
// ***********************************************************
$ful = FSO::join($tab, "tab.ini");

$ini = new iniMgr("design/config/tab.ini");
$ini->read($ful);
$ini->setChoice("props.typ", $tps, $typ);
$ini->setChoice("props.std", $arr, $std);
$ini->show();

?>
