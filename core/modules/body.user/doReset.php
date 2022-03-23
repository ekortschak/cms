<?php

incCls("dbase/dbQuery.php");

$sec = DBS::getState("main");

// ***********************************************************
// info
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/user/user.reset.tpl");

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

	$dbq = new dbQuery(NV, "dbusr");
	$xxx = $dbq->askMe(false);
	$inf = $dbq->query($flt);
	$chk = $inf["pwd"];

	if     ($new != $cnf) $sec = "mismatch";
	elseif ($old != $chk) $sec = "invalid";
	else {
		$sec = "info";
		$erg = $dbq->update(array("pwd" => $new), $flt);
		if (! $erg) $sec = "main";

		ENV::set("crdp", md5($new));
	}
}

// ***********************************************************
// show form
// ***********************************************************
$tpl->show($sec);

?>
