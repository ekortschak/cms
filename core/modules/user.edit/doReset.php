<?php

incCls("dbase/dbQuery.php");

$sec = CFG::dbState("main");

// ***********************************************************
// info
// ***********************************************************
$tpl = new tpl();
$tpl->load("user/user.reset.tpl");

if ($sec != "main") {
	return $tpl->show($sec);
}

// ***********************************************************
// check for action
// ***********************************************************
if (ENV::getPost("login.act") == 5) { // update pwd
	$flt = "uname='CUR_USER'";

	$old = ENV::getPost("opwd", "none"); $old = md5($old);
	$new = ENV::getPost("npwd", "new");
	$cnf = ENV::getPost("cpwd", "cnf");

	$dbq = new dbQuery(null, "dbusr");
	$xxx = $dbq->askMe(false);
	$inf = $dbq->query($flt);
	$chk = $inf["pwd"];

	if     ($new != $cnf) $sec = "mismatch";
	elseif ($old != $chk) $sec = "invalid";
	else {
		$sec = "info";
		$res = $dbq->update(array("pwd" => $new), $flt);
		if (! $res) $sec = "main";

		ENV::set("crdp", md5($new));
	}
}

// ***********************************************************
// show form
// ***********************************************************
$tpl->show($sec);

?>
