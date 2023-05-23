<?php

incCls("input/selector.php");
incCls("editor/usrEdit.php");

// ***********************************************************
// get ini vals
// ***********************************************************
$mgr = new usrEdit();
$mgr->setScope("U");

// ***********************************************************
// show editor
// ***********************************************************
$sel = new selector();
$pwd = $sel->pwd("usr.pwd");
$agn = $sel->pwd("usr.pwd2");
$act = $sel->show();

// ***********************************************************
// check and act
// ***********************************************************
if (! $mgr->chkPwd($pwd, $agn)) return;

$mgr->cnfUser("usr.change pwd");
$mgr->usrEdit($pwd);

?>
