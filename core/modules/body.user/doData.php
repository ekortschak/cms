<?php

incCls("dbase/recEdit.php");

$sec = ENV::dbState("main");

// ***********************************************************
// info
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/user/user.edit.tpl");
$tpl->set("user", CUR_USER);

if ($sec != "main") {
	return $tpl->show($sec);
}

// ***********************************************************
// check for action
// ***********************************************************
if (ENV::getPost("rec.act")) {
	$tpl->show("done");
	return;
}
$tpl->show("main");

// ***********************************************************
// offer data for editing
// ***********************************************************
$dbe = new recEdit(NV, "dbusr");
$dbe->lock("uname");
$dbe->skip("pwd");
$dbe->findRec("uname='CUR_USER'");
$dbe->permit("e");
$dbe->show();

?>

