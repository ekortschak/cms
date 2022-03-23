<?php

if (! FS_ADMIN) return;

// ***********************************************************
$loc = PFS::getLoc();
$dir = APP::dir(__DIR__);

switch (! is_dir($loc)) {
	case true: MSG::long("not.native"); break;
	default:   MSG::long("native");
}

// ***********************************************************
// show content
// ***********************************************************
incCls("menus/buttons.php");

$nav = new buttons("tab", "P", $dir);
$nav->add("T", "doTabs");
$nav->add("R", "doSort");
$nav->add("P", "doProps");
$nav->add("G", "doPics");
$nav->show();

$nav->showContent();

?>
