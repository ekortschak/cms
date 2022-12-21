<?php

incCls("menus/dboBox.php");
incCls("menus/qikSelect.php");
incCls("dbase/dbQuery.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

// ***********************************************************
HTM::tag("data.clean");
// ***********************************************************
$dbq = new dbQuery($dbs, $tbl);
$vls = $dbq->getDVs($fld);

$box = new qikSelect();
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
