<?php

// ***********************************************************
// get user list from config file
// ***********************************************************
$ini = new ini("config/users.ini");
$arr = $ini->getValues($ful, "user"); ksort($arr);

$ini = new code();
$xxx = $ini->readPath(CUR_PAGE);
$prm = $ini->getValues("perms");

// ***********************************************************
// show permissions
// ***********************************************************
$tpl = new tpl();
$tpl->load("input/selCombo.tpl");
$tpl->load("editor/menu.perms.tpl");
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
