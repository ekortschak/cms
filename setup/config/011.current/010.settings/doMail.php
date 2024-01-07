<?php

incCls("user/mail.php");

// ***********************************************************
// read and write data
// ***********************************************************
$mgr = new iniMgr("mail.def");
$mgr->read("config/mail.ini");
$mgr->setScope();
$mgr->edit();

// ***********************************************************
HTW::xtag("mail.test");
// ***********************************************************
if (MAILMODE == "none") {
	return MSG::now("mail.off");
}
$mel = new mail();
$chk = $mel->test();

$msg = "no.connection"; if ($chk)
$msg = "mail.con";

MSG::now($msg);

?>
