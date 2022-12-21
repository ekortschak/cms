<?php

incCls("menus/dropBox.php");
incCls("input/selector.php");
incCls("input/confirm.php");
incCls("editor/iniWriter.php");

// ***********************************************************
// show menu
// ***********************************************************
$sel = new selector();
$grp = $sel->input("grp.name", "new_group");
$xxx = $sel->show();

if (! CHK::user($grp)) {
	MSG::now("grp.bad");
	return;
}

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->dic("grp.addx", $grp);
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// store info
// ***********************************************************
$fil = "config/users.ini";

$ini = new iniWriter($fil);
$ini->addSec($grp);
$ini->save();

?>
