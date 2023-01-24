<?php

incCls("menus/dropBox.php");
incCls("input/confirm.php");
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
$box = new dropBox("menu");
$grp = $box->getKey("group", $gps); $acs = $ini->getKeys($grp);
$usr = $box->getKey("user", $acs);
$box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->dic("usr.drop", $usr);
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// store info
// ***********************************************************
$ini->drop($grp, $usr);
$ini->save();

?>
