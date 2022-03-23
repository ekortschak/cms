<?php

incCls("menus/dropbox.php");
incCls("dbase/dbQuery.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$ret = $box->showDBObjs("BTF"); extract($ret);

// ***********************************************************
// show options
// ***********************************************************
$dbq = new dbQuery($dbs, $tbl);
$vls = $dbq->getDVs($fld);

$val = $box->getKey("change.from", $vls); unset($vls[$val]);
$new = $box->getKey("change.to", $vls);
$xxx = $box->show("table");

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("data.clean");

$vls = array($fld => $new);
$flt = "$fld='$val'";

$dbq->update($vls, $flt);

?>
