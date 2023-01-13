<?php

if (FS_ADMIN) return;

$edt = CFG::getVar("mods", "eopts.medit", false);
$mod = ($edt) ? "login" : "stop";

incMod("body/$mod.php");

?>
