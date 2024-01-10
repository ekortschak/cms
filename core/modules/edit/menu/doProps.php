<?php

incCls("editor/iniMgr.php");
incCls("editor/ediMgr.php");

// ***********************************************************
HTW::xtag("page.props");
// ***********************************************************
$loc = PGE::$dir;
$fil = FSO::join($loc, "page.ini");

$tab = new iniTab(TAB_HOME);
$fst = $tab->get("props.std");
$fst = PFS::find($fst); // index of default page
$chk = PGE::isCurrent($fst);

$sel = new selector();
$sel->check("default", $chk);
$sel->show();

// ***********************************************************
// show ini editor
// ***********************************************************
$edi = new ediMgr();
$edi->edit($fil);

?>
