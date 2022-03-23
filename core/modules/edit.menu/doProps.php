<?php

incCls("editor/iniMgr.php");

$loc = PFS::getLoc();

// ***********************************************************
HTM::Tag("tab.props");
// ***********************************************************
$tab = new iniTab(TAB_PATH);
$fst = $tab->get("props.std");
$fst = PFS::getIndex($fst); // index of default page
$cur = PFS::getIndex($loc); // index of current page
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

$tpl = "design/config/page.ini"; if ($typ != "inc")
$tpl = "design/config/page.$typ.ini";

// ***********************************************************
HTM::Tag("page.props");
// ***********************************************************
$ini = new iniMgr($tpl);
$ini->read($ful);
$ini->show();

?>
