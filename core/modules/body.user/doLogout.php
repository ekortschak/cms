<?php

$tpl = new tpl();
$tpl->read("design/templates/user/logout.tpl");
$act = ENV::getPost("login.act", 0);
$sec = "main";

// ***********************************************************
// check for action
// ***********************************************************
if (CUR_USER == "www") $sec = "noauth";
elseif ($act == 2)     $sec = "done";

elseif ($act == 7) {
	$dbq = new dbQuery(NV, "dbusr");
	$xxx = $dbq->askMe(false);
	$res = $dbq->delete("uname='CUR_USER'");

	$sec = "deleted"; if (! $res) $sec = "error";
}

// ***********************************************************
// show form
// ***********************************************************
$tpl->show($sec);

?>
