<?php

incCls("menus/dropDbo.php");
incCls("dbase/dbQuery.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

// ***********************************************************
HTW::xtag("data.clean");
// ***********************************************************
$dbq = new dbQuery($dbs, $tbl);
$vls = $dbq->getDVs($fld);

$box = new dropBox("table");
$val = $box->getKey("change.from", $vls); unset($vls[$val]);
$new = $box->getKey("change.to", $vls);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$vls = array($fld => $new);
$flt = "$fld='$val'";

$dbq->update($vls, $flt);

?>
