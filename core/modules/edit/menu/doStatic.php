<?php

if (ENV::getPost("mnu_stat")) {
	PFS::toggle();
}

// ***********************************************************
// ask for confirmation
// ***********************************************************
$sts = PFS::isStatic();
$sec = "act.freeze"; if ($sts)
$sec = "act.thaw";

$tpl = new tpl();
$tpl->load("editor/menu.stat.tpl");
$tpl->substitute("act", $sec);
$tpl->show();

?>
