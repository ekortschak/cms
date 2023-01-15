<?php

$loc = PFS::getLoc();
$dir = FSO::join($loc, "snip");
$arr = FSO::files($dir);
$lst = array();

foreach ($arr as $fil => $nam) {
	$nam = STR::between($nam, "snip.", ".php");
	$nam = STR::after($nam, ".");
	$lst[$fil] = $nam;
}

// ***********************************************************
incCls("menus/dropNav.php");
// ***********************************************************
$box = new dropNav();
$fil = $box->getKey("snip", $lst);
$xxx = $box->show();

// ***********************************************************
incCls("other/tutorial.php");
// ***********************************************************
$cod = new tutorial();
$cod->snip($fil);

?>
