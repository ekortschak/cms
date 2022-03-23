<?php

$loc = PFS::getLoc();
$ptn = FSO::join($loc, "snip.*.*");
$arr = FSO::files($ptn);
$lst = array();

foreach ($arr as $fil => $nam) {
	$nam = STR::between($nam, "snip.", ".php");
	$nam = STR::after($nam, ".");
	$lst[$fil] = $nam;
}

// ***********************************************************
incCls("menus/dropnav.php");
// ***********************************************************
$box = new dropnav();
$fil = $box->getKey("snip", $lst);
$nam = $box->decode("snip", $fil);
$xxx = $box->show();

// ***********************************************************
incCls("other/tutorial.php");
// ***********************************************************
$cod = new tutorial();
$cod->snip($fil, $nam);

?>
