<?php

if (FS_ADMIN) return;

DBG::file(__FILE__);

// ***********************************************************
$edt = CFG::mod("eopts.medit", false);
$mod = ($edt) ? "body/login" : "msgs/stop";

incMod("$mod.php");

?>
