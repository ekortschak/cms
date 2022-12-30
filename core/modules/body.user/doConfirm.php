<?php

incCls("dbase/dbQuery.php");

$md5 = ENV::getPost("code", NV);
$sec = ENV::dbState("main");

// ***********************************************************
// info
// ***********************************************************
$tpl = new tpl();
$tpl->load("user/reg.confirm.tpl");

if ($sec == "nouser"); else
if ($sec != "main") return $tpl->show($sec);
$sec = "main";

// ***********************************************************
// check for action
// ***********************************************************
if (ENV::getPost("login.act") == 6) { // confirm account
	$md5 = ENV::getPost("md5", NV);
	$sec = "done";

	if (strlen($md5) != 32) $sec = "error";
	else {
		$vls = array("status" => "verified", "acticode" => date("Y-m-d"));
		$flt = "md5(ID)='$md5'";

		$dbq = new dbQuery(NV, "dbusr");
		$xxx = $dbq->askMe(false);
		$chk = $dbq->isRecord($flt); if ($chk)
		$chk = $dbq->replace($vls, $flt, false);

		if (! $chk) $sec = "error";
	}
}

// ***********************************************************
// show form
// ***********************************************************
$tpl->set("md5", $md5);
$tpl->show($sec);

?>
