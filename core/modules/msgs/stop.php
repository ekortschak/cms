<?php

if (FS_ADMIN) return;

DBG::file(__FILE__);

// ***********************************************************
$edt = CFG::mod("eopts.medit", false);
$mod = ($edt) ? "login" : "stop";

incMod("body/$mod.php");

?>
