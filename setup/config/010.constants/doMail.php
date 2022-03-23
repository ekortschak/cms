<?php

incCls("editor/iniMgr.php");

// ***********************************************************
// read and write data
// ***********************************************************
$fil = "config/mail.ini";

$ini = new iniMgr("design/config/mail.ini");
$ini->read($fil);
$ini->save($fil);
$ini->show();

// ***********************************************************
// visual feedback
// ***********************************************************
HTM::tag("mail.check");

if (MAILMODE == "none") {
	return MSG::now("mail.off");
}

incCls("user/mail.php");
$mel = new mail();
$chk = $mel->test();
$chk = intval($chk);

MSG::now("mail.con", $chk);

?>
