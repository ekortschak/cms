<?php

incCls("menus/dropBox.php");
incCls("input/selector.php");
incCls("input/confirm.php");
incCls("editor/iniWriter.php");

// ***********************************************************
$fil = "config/users.ini";

$ini = new iniWriter($fil);
$gps = $ini->getSecs();

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropBox("menu");
$grp = $box->getKey("group", $gps);
$box->show();

$sel = new selector();
$usr = $sel->input("usr.account");
$pwd = $sel->pwd("usr.pwd");
$agn = $sel->pwd("usr.pwd2");
$act = $sel->show();

// ***********************************************************
// check user & password
// ***********************************************************
if (! $usr) {
	MSG::now("usr.bad");
	return;
}

if (! CHK::pwd($pwd, $agn)) {
	MSG::now("pwd.bad");
	return;
}

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->dic("usr.add", $usr);
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// store info
// ***********************************************************
$ini->set("$grp.$usr", md5($pwd));
$ini->save();

?>
