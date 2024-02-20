<?php

DBG::file(__FILE__);

if (! FS_ADMIN) {
	return APP::mod("msgs/stop");
}

// ***********************************************************
// check context
// ***********************************************************
$loc = PGE::$dir;

if (! is_dir($loc)) return MSG::now("not.appliccable");

// ***********************************************************
// find relevant editors
// ***********************************************************
incCls("editor/ediMgr.php");

$edi = new ediMgr(true);
$edi->edit($loc);

?>
