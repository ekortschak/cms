<?php

$ini = new ini(dirname($fil));
$uid = $ini->getUID();

$tpl = new tpl();
$tpl->read("design/templates/editor/viewEdit.tpl");
$tpl->set("file", FSO::clearRoot($fil));
$tpl->set("title", $uid);

// ***********************************************************
// show data
// ***********************************************************
incCls("dbase/tblMgr.php");

$md5 = md5($fil);

$few = new tblMgr(NV, "copyright");
$few->addFilter("md5='$fld'");
$few->permit("w");
$few->show();

?>
