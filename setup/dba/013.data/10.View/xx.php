<?php

incCls("menus/dropbox.php");
incCls("dbase/tblMgr.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$ret = $box->showDBObjs("BTF"); extract($ret);

// ***********************************************************
// show data
// ***********************************************************
$few = new tblMgr($dbs, $tbl);
$few->addFilter($fld);
$few->permit("w");
$few->show();

?>
