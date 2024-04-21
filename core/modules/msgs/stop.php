<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
if (FS_ADMIN) return;

$edt = CFG::mod("eopts.medit", false);

// ***********************************************************
// act
// ***********************************************************
switch ($edt) {
	case true: APP::mod("body/login"); break;
	default:   APP::mod("msgs/stop");
}

?>
