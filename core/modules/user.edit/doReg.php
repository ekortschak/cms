<?php

incCls("dbase/dbQuery.php");
incCls("dbase/recEdit.php");
incCls("user/mail.php");

$sec = ENV::dbState("main");

// ***********************************************************
// info
// ***********************************************************
$tpl = new tpl();
$tpl->load("user/reg.info.tpl");

if ($sec == "main") {
	return $tpl->show($sec);
}

// ***********************************************************
// check for action
// ***********************************************************
if (ENV::getPost("rec.act")) {
	$usr = ENV::getPost("uname");
	$pwd = ENV::getPost("pwd"); notify($usr, $pwd);
	return;
}

// ***********************************************************
HTW::xtag("usr.register");
// ***********************************************************
$dbe = new recEdit(null, "dbusr");
$dbe->findRec();
$dbe->permit("a");
$dbe->show();

// ***********************************************************
// show data policy
// ***********************************************************
$tpl->load("user/dsgvo.tpl");
$tpl->show("dsgvo");
return;


// ***********************************************************
// notify user
// ***********************************************************
function notify($usr, $pwd) {
 // user has already been added by class tan

	$tpl = new tpl();
	$tpl->load("user/reg.sent.tpl");
	$md5 = md5($pwd);

	$dbq = new dbQuery(null, "dbusr");
	$inf = $dbq->query("uname='$usr' AND pwd='$md5'"); if (! $inf) return $tpl->show("error");

	$mel = new mail("mail.register");
	$mel->read("$dir/confirm.tpl");
	$mel->merge($inf);
	$mel->set("md5", md5($inf["ID"]));
	$mel->set("pwd", $pwd);
	$mel->set("msg", $mel->getSection("message"));
	$mel->addRecipient($inf["email"]);

	$sec = "main"; if (! $mel->send()) $sec = "nomail";
	$tpl->show($sec);
}
?>

