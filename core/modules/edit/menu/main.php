<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
if (! FS_ADMIN) {
	return APP::mod("msgs/stop");
}

// ***********************************************************
// check context
// ***********************************************************
$loc = PGE::$dir;

if (! is_dir($loc)) return MSG::now("not.appliccable");

incCls("menus/buttons.php");

#HTW::xtag("medit.title", "h3");

// ***********************************************************
$nav = new buttons("menu", "F", __DIR__);
// ***********************************************************
$nav->add("D", "doFolders");
$nav->add("R", "doSort",   "sort");
$nav->add("U", "doUser");
$nav->space();
$nav->add("F", "doFiles");
$nav->add("A", "doUpload", "upload");
$nav->add("Q", "doQR");
$nav->space();
$nav->add("P", "doProps",  "props");
$nav->space();
$nav->add("C", "doClip",   "clip");
$nav->space();
$nav->space();
#$nav->add("S", "doStatic", "static");
$nav->add("I", "doInfo",   "info");
$nav->show();

?>
