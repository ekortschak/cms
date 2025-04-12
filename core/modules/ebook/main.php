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

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("ebook", "B", __DIR__);
$nav->add("T", "doToC");
$nav->add("B", "doDoc");
$nav->space();
$nav->add("F", "doLFs", "mprops.ebook");
$nav->add("E", "doEdit", "edit");
$nav->space();
$nav->add("P", "doPages", "upload");
$nav->show();

?>
