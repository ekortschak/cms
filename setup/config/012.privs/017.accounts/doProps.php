<?php

incCls("menus/localMenu.php");
incCls("input/confirm.php");
incCls("input/selector.php");
incCls("editor/iniWriter.php");

// ***********************************************************
// get ini vals
// ***********************************************************
$fil = "config/users.ini";

$ini = new iniWriter($fil);
$gps = $ini->getSecs();

if (! $gps) {
	return MSG::now("no.grps.edit");
}

// ***********************************************************
// show menu
// ***********************************************************
$box = new localMenu();
$grp = $box->getKey("group", $gps); $acs = $ini->getKeys($grp);
$usr = $box->getKey("user", $acs);
$box->show();

$sel = new selector();
$pwd = $sel->pwd("usr.pwd");
$agn = $sel->pwd("usr.pwd2");
$act = $sel->show();

// ***********************************************************
// check password
// ***********************************************************
if (! CHK::pwd($pwd, $agn)) {
	MSG::now("pwd.bad");
	return;
}

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->dic("usr.change pwd", $usr);
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// store info
// ***********************************************************
$ini->set("$grp.$usr", md5($pwd));
$ini->save();

?>
