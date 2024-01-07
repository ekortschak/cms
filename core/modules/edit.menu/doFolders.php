<?php

if (PFS::isStatic()) {
	return MSG::now("mnu.static");
}

$loc = PGE::$dir;

// ***********************************************************
// set state
// ***********************************************************
$lev =  PGE::level($loc);
$sts = (FSO::isHidden($loc)) ? "on" : "off";

// ***********************************************************
// show options
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/menu.folders.tpl");
$tpl->register();
$tpl->set("curloc", $loc);
$tpl->set("curdir", basename($loc));
$tpl->set("bulb", $sts);

if ($lev < 2) {
	$tpl->substitute("nodes.move", "nodes.top");
}

$tpl->show();

?>

