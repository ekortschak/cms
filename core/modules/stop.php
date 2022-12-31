<?php

if (! FS_ADMIN) {
	$mod = "stop";
	$edt = CFG::getVar("mods", "eopts.medit", false);
	if ($edt) $mod = "login";

	incMod("body/$mod.php");
}

?>
