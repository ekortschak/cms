<?php

incCls("menus/dropbox.php");
incCls("input/confirm.php");

// ***********************************************************
// get ini vals
// ***********************************************************
$arr = CFG::getCfg("users");

if (! $arr) {
	return MSG::now("no.grps.edit");
}

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$usr = $box->getKey("group", $arr);
$box->show("menu");

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->add("group.drop");
$cnf->show();

?>
