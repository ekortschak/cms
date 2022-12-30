<?php

incCls("dbase/dbQuery.php");
incCls("user/mail.php");

$sec = ENV::dbState("main");

// ***********************************************************
// info
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/user/forgot.tpl");

if ($sec == "nouser");  else
if ($sec != "main")     return $tpl->show($sec);
if (MAILMODE == "none") return $tpl->show("cfg.usemail");

// ***********************************************************
// check for action
// ***********************************************************
if (ENV::getPost("login.act") == 4) { // send requested
	$sec = "success";
	$flt = "uname='CUR_USER'";
	$new = uniqid();

	$dbq = new dbQuery(NV, "dbusr");
	$inf = $dbq->query($flt);

	if (! $dbq->update(array("pwd" => $new, $flt))) {
		$sec = "dberror";
	}
	else {
		$adr = ENV::getPost("mail", "nobody@home.net");

		$mel = new mail("Password Reset");
		$mel->read("design/templates/user/mail.pwd.tpl");
		$mel->set("uname", $inf["uname"]);
		$mel->set("email", $inf["email"]);
		$mel->set("pwd",   $new);
		$mel->set("msg",   $mel->getSection("message"));
		$mel->addRecipient($adr);

		if (! $mel->send()) $sec = "nomail";
	}
}

// ***********************************************************
// show info
// ***********************************************************
$tpl->show($sec);

?>
