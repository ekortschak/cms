<?php

incCls("editor/iniMgr.php");

// ***********************************************************
HTW::xtag("tab.props");
// ***********************************************************
$tab = new iniTab(TAB_PATH);
$fst = $tab->get("props.std");

$fst = PFS::getIndex($fst);     // index of default page
$cur = PFS::getIndex(PGE::$dir); // index of current page
$stc = PFS::isStatic();

$chk = ($fst == $cur) ? "CHECKED" : "";

$sel = new selector();
$sel->check("default", $chk);
$sel->show();

// ***********************************************************
HTW::xtag("page.props");
// ***********************************************************
$mgr = new iniMgr();
$mgr->read($cur);
$mgr->setScope();
$mgr->edit();

?>
