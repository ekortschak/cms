<?php

incCls("dbase/recEdit.php");

// ***********************************************************
// show copy right properties
// ***********************************************************
HTW::tag("(CR)-Information", "b");

if (DB_MODE != "none") {
	$md5 = md5($fil);

	$dbe = new recEdit(NV, "copyright");
	$dbe->setDefault("md5", $md5);
	$dbe->setDefault("holder", "Glaube ist mehr");
	$dbe->setDefault("source", "https://glaubeistmehr.at");
	$dbe->setDefault("perms", "free");
	$dbe->setDefault("verified", 1);

	$dbe->hide("md5,owner,verified");
	$dbe->permit("ed");

	$dbe->findRec("md5='$md5'");
	$dbe->show();
}

// ***********************************************************
// show editor
// ***********************************************************
$uid = PGE::getUID($fil);

$tpl = new tpl();
$tpl->load("editor/edit.pic.tpl");
$tpl->set("title", $uid);
$tpl->set("file", APP::relPath($fil));
$tpl->set("path", APP::tempDir("curedit"));
$tpl->show();

?>
