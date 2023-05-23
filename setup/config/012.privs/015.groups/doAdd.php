<?php

incCls("input/selector.php");
incCls("editor/usrEdit.php");

// ***********************************************************
// show editor
// ***********************************************************
$sel = new selector();
$grp = $sel->input("grp.name", "new_group");
$usr = $sel->input("usr.account");
$pwd = $sel->pwd("usr.pwd");
$agn = $sel->pwd("usr.pwd2");
$act = $sel->show();

// ***********************************************************
// check and act
// ***********************************************************
$mgr = new usrEdit();

if (! $mgr->chkGroup($grp)) return;
if (! $mgr->chkUser($usr)) return;
if (! $mgr->chkPwd($pwd, $agn)) return;

$mgr->cnfGroup("grp.addx");
$mgr->grpAdd($grp, $usr, $pwd);

?>
