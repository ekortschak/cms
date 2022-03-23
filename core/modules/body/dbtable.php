<?php

$ini = new ini();
$dbs = $ini->get("props.dbase", false); if (! $dbs) return;
$tbl = $ini->get("props.table", false); if (! $tbl) return;
$prm = $ini->get("props.permit", "r");

// ***********************************************************
// show page content
// ***********************************************************
incCls("dbase/tblMgr.php");

$few = new tblMgr($dbs, $tbl);
$few->reset();
$few->permit($prm);
$few->show();

?>
