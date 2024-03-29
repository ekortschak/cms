<?php

incCls("menus/dropDbo.php");
incCls("tables/sel_table.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$grp = $box->getGroups($dbs);
$prm = $box->getPrivs("f");
$xxx = $box->show();

// ***********************************************************
HTW::xtag("fld.perms");
// ***********************************************************
$few = new sel_table();
$few->setTable($dbs, "dbxs", "spec LIKE '$tbl.%'");
$few->setButton($grp, $prm);
$few->setProp("spec", "head", DIC::get("db.field"));
$few->setProp("cat", "hide", true);
$few->show();

?>
