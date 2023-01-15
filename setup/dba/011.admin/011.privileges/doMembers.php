<?php

incCls("menus/dropDbo.php");
incCls("tables/sel_table.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$grp = $box->getGroups($dbs);
$prm = $box->getPrivs("g");
$xxx = $box->show();

// ***********************************************************
HTW::xtag("grp.perms");
// ***********************************************************
$few = new sel_table();
$few->setTable($dbs, "dbxs", "cat='usr'");
$few->setButton($grp, $prm);
$few->setProp("spec", "head", DIC::get("db.group"));
$few->setProp("cat", "hide", true);
$few->show();

?>
