<?php

$inc = FSO::join(__DIR__, "common.php");
$inc = APP::relPath($inc);
$fcs = "mail";

include($inc);

// ***********************************************************
HTW::xtag("mail.check");
// ***********************************************************
if (MAILMODE == "none") {
	return MSG::now("mail.off");
}

$mel = new mail();
$chk = $mel->test();
$chk = intval($chk);

MSG::now("mail.con", $chk);

?>
