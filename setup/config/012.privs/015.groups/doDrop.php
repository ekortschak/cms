<?php

incCls("editor/usrEdit.php");

// ***********************************************************
// get ini vals
// ***********************************************************
$mgr = new usrEdit();
$mgr->setScope("R");

if (! $mgr->cnfGroup("grp.drop")) return;

// ***********************************************************
// show choices
// ***********************************************************
$grp = $mgr->info("group");
$arr = $mgr->values($grp);
$cnt = count($arr);

MSG::now("grp.count", $cnt);
ENV::set("grp.drop", $grp);

// ***********************************************************
// check and act
// ***********************************************************
// TODO: action too late for display
$mgr->grpDrop($grp);

?>
