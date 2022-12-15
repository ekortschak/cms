<?php

incCls("dbase/dbQuery.php");
incCls("dbase/recEdit.php");
incCls("user/mail.php");

$sec = DBS::getState("main");

// ***********************************************************
// info
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/user/reg.info.tpl");

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
HTM::tag("usr.register");
// ***********************************************************
$dbe = new recEdit(NV, "dbusr");
$dbe->findRec();
$dbe->permit("a");
$dbe->show();

// ***********************************************************
// show data policy
// ***********************************************************
$tpl->read("design/templates/user/dsgvo.tpl");
$tpl->show("dsgvo");
return;


// ***********************************************************
// notify user
// ***********************************************************
function notify($usr, $pwd) {
 // user has already been added by class tan

	$tpl = new tpl();
	$tpl->read("design/templates/user/reg.sent.tpl");
	$md5 = md5($pwd);

	$dbq = new dbQuery(NV, "dbusr");
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

