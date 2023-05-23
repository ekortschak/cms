<?php

incCls("input/selector.php");
incCls("editor/usrEdit.php");

// ***********************************************************
$mgr = new usrEdit();
$mgr->setScope();

// ***********************************************************
// show editor
// ***********************************************************
$sel = new selector();
$usr = $sel->input("usr.account");
$pwd = $sel->pwd("usr.pwd");
$agn = $sel->pwd("usr.pwd2");
$act = $sel->show();

// ***********************************************************
// check and act
// ***********************************************************
if (! $mgr->chkUser($usr)) return;
if (! $mgr->chkPwd($pwd, $agn)) return;

$mgr->confirm("usr.add", $usr);
$mgr->usrAdd($usr, $pwd);

?>
