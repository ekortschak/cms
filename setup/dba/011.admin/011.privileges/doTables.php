<?php

incCls("menus/dropDbo.php");
incCls("tables/sel_table.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$grp = $box->getGroups($dbs);
$prm = $box->getPrivs("t");
$xxx = $box->show();

// ***********************************************************
HTW::xtag("tbl.perms");
// ***********************************************************
$few = new sel_table();
$few->setTable($dbs, "dbxs", "cat='tbl'");
$few->setButton($grp, $prm);
$few->setProp("spec", "head", DIC::get("db.table"));
$few->setProp("cat", "hide", true);
$few->show();

?>
