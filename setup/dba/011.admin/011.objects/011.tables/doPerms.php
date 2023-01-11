<?php

incCls("menus/dboBox.php");
incCls("tables/sel_table.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$grp = $box->getGroups($dbs, true);
$prm = $box->getPrivs("f");
$xxx = $box->show();

// ***********************************************************
HTW::xtag("tbl.perms");
// ***********************************************************
$few = new sel_table();
$few->setTable($dbs, "dbxs", "spec LIKE '$tbl.%'");
$few->setButton($grp, $prm);
$few->setProp("cat", "hide", true);
$few->show();

?>
