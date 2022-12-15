<?php

incCls("menus/dropbox.php");
incCls("input/confirm.php");
incCls("editor/iniWriter.php");

// ***********************************************************
// get ini vals
// ***********************************************************
$fil = "config/users.ini";

$ini = new iniWriter($fil);
$cnf = new confirm();

if ($cnf->act()) {
	$ini->dropSec(ENV::get("grp.drop"));
	$ini->save();
}

$gps = $ini->getSecs();

unset($gps["admin"]);
unset($gps["user"]);

if (! $gps) {
	return MSG::now("no.grps.edit");
}

// ***********************************************************
// show choices
// ***********************************************************
$box = new dbox();
$grp = $box->getKey("group", $gps); $acs = $ini->getKeys($grp);
$arr = $ini->getValues($grp);
$cnt = count($arr);

MSG::now("grp.count", $cnt);
ENV::set("grp.drop", $grp);

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf->dic("grp.drop", $grp);
$cnf->show();

?>
