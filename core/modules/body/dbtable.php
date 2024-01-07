<?php

DBG::file(__FILE__);

// ***********************************************************
$dbs = PGE::get("props.dbase", false); if (! $dbs) return;
$tbl = PGE::get("props.table", false); if (! $tbl) return;
$prm = PGE::get("props.permit", "r");

// ***********************************************************
// show page content
// ***********************************************************
incCls("dbase/tblMgr.php");

$few = new tblMgr($dbs, $tbl);
$few->reset();
$few->permit($prm);
$few->show();

?>
