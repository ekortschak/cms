<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("editor/ediMgr.php");

// ***********************************************************
// show title
// ***********************************************************
$fil = APP::find(CUR_PAGE);
$tit = PGE::getTitle();
$std = ENV::get("pic.file");
$std = FSO::join(CUR_PAGE, $std);

HTW::tag($tit, "h3");

// ***********************************************************
// find relevant editors
// ***********************************************************
$edi = new ediMgr(true);
$edi->edit(CUR_PAGE);

?>
