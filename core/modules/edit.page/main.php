<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("editor/ediMgr.php");

$loc = PGE::$dir;

// ***********************************************************
// show title
// ***********************************************************
$fil = APP::find($loc);
$tit = PGE::getTitle();
$std = ENV::get("pic.file");
$std = FSO::join($loc, $std);

HTW::tag($tit, "h3");

// ***********************************************************
// find relevant editors
// ***********************************************************
$edi = new ediMgr(true);
$edi->edit($loc);

?>
