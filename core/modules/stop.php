<?php

if (FS_ADMIN) return;

$edt = CFG::mod("eopts.medit", false);
$mod = ($edt) ? "login" : "stop";

incMod("body/$mod.php");

?>
