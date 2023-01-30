<?php

incCls("editor/iniMgr.php");

// ***********************************************************
HTW::xtag("tab.props");
// ***********************************************************
$tab = new iniTab(TAB_PATH);
$fst = $tab->get("props.std");
$fst = PFS::getIndex($fst);     // index of default page
$cur = PFS::getIndex(CUR_PAGE); // index of current page
$stc = PFS::isStatic();

$chk = ($fst == $cur) ? "CHECKED" : "";

$sel = new iniEdit();
$sel->check("default", $chk);
$sel->show();

// ***********************************************************
// detect template
// ***********************************************************
$ful = FSO::join($cur, "page.ini");

$ini = new ini($ful);
$typ = $ini->get("props.typ", "inc");
$typ = STR::left($typ);

$tpl = "LOC_CFG/page.$typ.def"; if (! is_file($tpl))
$tpl = "LOC_CFG/page.def";

// ***********************************************************
HTW::xtag("page.props");
// ***********************************************************
$ini = new iniMgr($tpl);
$ini->exec($ful);
$ini->show();

?>
