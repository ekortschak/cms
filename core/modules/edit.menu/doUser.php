<?php

$loc = PFS::getLoc();

// ***********************************************************
// get user list from config file
// ***********************************************************
$ful = FSO::join("config", "users.ini");
$arr = PGE::getValues($ful, "user"); ksort($arr);

$ini = new code();
$xxx = $ini->readPath($loc);
$prm = $ini->getValues("perms");

// ***********************************************************
// show permissions
// ***********************************************************
$tpl = new tpl();
$tpl->load("input/selCombo.tpl");
$tpl->load("editor/mnuPerms.tpl");
$out = "";

foreach ($arr as $usr => $md5) {
	$rgt = VEC::get($prm, $usr, "i");

	$tpl->set("user", $usr);
	$tpl->set("r", "");
	$tpl->set("i", "");
	$tpl->set("d", ""); $tpl->set($rgt, "checked");

	$out.= $tpl->getSection("item");
}
$tpl->set("items", $out);
$tpl->show();

?>
