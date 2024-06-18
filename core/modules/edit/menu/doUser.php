<?php

// ***********************************************************
// get user list from config file
// ***********************************************************
$arr = CFG::match("users:user");
$arr = VEC::sort($arr);

$ini = new code();
$xxx = $ini->readPath(PGE::$dir);
$prm = $ini->values("perms");

// ***********************************************************
// show permissions
// ***********************************************************
$tpl = new tpl();
$tpl->load("input/selCombo.tpl");
$tpl->load("editor/menu.perms.tpl");
$tpl->register();
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
