<?php

if (FS_ADMIN) return;

DBG::file(__FILE__);

// ***********************************************************
$edt = CFG::mod("eopts.medit", false);

switch ($edt) {
	case true: APP::mod("body/login"); break;
	default:   APP::mod("msgs/stop");
}

?>
