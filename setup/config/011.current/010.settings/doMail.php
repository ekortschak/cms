<?php

$inc = APP::getInc(__DIR__, "common.php");
$fcs = "mail";

include $inc;

// ***********************************************************
HTW::xtag("mail.check");
// ***********************************************************
if (MAILMODE == "none") {
	return MSG::now("mail.off");
}

// ***********************************************************
incCls("user/mail.php");

$mel = new mail();
$chk = $mel->test();
$chk = intval($chk);

MSG::now("mail.con", $chk);

?>
