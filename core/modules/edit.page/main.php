<?php

if (! FS_ADMIN) {
	incMod("msgs/stop.php");
	return;
}

DBG::file(__FILE__);

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
