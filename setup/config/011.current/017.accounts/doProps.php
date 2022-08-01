<?php

incCls("menus/dropbox.php");
incCls("input/confirm.php");
incCls("input/selector.php");

// ***********************************************************
// get ini vals
// ***********************************************************
$arr = CFG::getCfg("users");

if (! $arr) {
	return MSG::now("no.grps.kill");
}

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$usr = $box->getKey("group", $arr);
$box->show("menu");

$sel = new selector();
$xxx = $sel->hidden("user", "usrEdit");
$usr = $sel->hidden("account", $usr);
$pwd = $sel->pwd("pwd");
$act = $sel->show();

?>
