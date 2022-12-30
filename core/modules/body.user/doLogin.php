<?php

$tpl = new tpl();
$tpl->load("user/login.tpl");
$sec = "current";

// ***********************************************************
// login independent of DB, used also for FS
// ***********************************************************
if (ENV::getPost("login.act", 0) == 1) {
	if (DB_LOGIN || FS_LOGIN) {
		$tpl->show("success");
		$tpl->show("force.logout");
		return;
	}
	$sec = "error";
}

// ***********************************************************
// show form & info
// ***********************************************************
$tpl->show($sec);
$tpl->show();

?>
