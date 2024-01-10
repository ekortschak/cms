<?php

$sec = CFG::dbState("main");

// ***********************************************************
// check for action
// ***********************************************************
if (ENV::getPost("login.act", 0) == 7) {
	$dbq = new dbQuery(null, "dbusr");
	$xxx = $dbq->askMe(false);
	$res = $dbq->delete("uname='CUR_USER'");

	$sec = "deleted"; if (! $res)
	$sec = "error";
}

// ***********************************************************
// show form
// ***********************************************************
$tpl = new tpl();
$tpl->load("user/user.drop.tpl");
$tpl->set("user", CUR_USER);
$tpl->show($sec);

?>
