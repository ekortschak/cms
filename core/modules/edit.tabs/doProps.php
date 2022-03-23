<?php

incCls("menus/tabs.php");
incCls("menus/dropbox.php");
incCls("editor/iniMgr.php");
incCls("files/iniTab.php");

// ***********************************************************
// collect info
// ***********************************************************
$tbs = new tabset();
$arr = $tbs->validSets();

$idx = APP_CALL;
$tab = trim(TAB_ROOT, "/");

// ***********************************************************
// show file selector
// ***********************************************************
$box = new dbox();
$set = $box->getVal("TabSet", $arr, $idx);
$lst = $tbs->getTabs($set, true);
$tab = $box->getKey("Tab", $lst, $tab);
$xxx = $box->show("menu");

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

if ($arr) $lst = $arr;

// ***********************************************************
HTM::Tag("Props");
// ***********************************************************
$ful = FSO::join($tab, "tab.ini");

$ini = new iniMgr("design/config/tab.ini");
$ini->read($ful);
$ini->setChoice("props.typ", $tps, $typ);
$ini->setChoice("props.std", $lst, $std);
$ini->show();

?>
