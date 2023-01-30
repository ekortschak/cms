<?php

if (PFS::isStatic()) {
	return MSG::now("mnu.static");
}

// ***********************************************************
// set state
// ***********************************************************
$lev =  PFS::getLevel(CUR_PAGE);
$sts = (FSO::isHidden(CUR_PAGE)) ? "on" : "off";

// ***********************************************************
// show options
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/menu.folders.tpl");
$tpl->set("curloc", CUR_PAGE);
$tpl->set("curdir", basename(CUR_PAGE));
$tpl->set("bulb", $sts);

if ($lev < 2) {
	$tpl->substitute("nodes.move", "nodes.top");
}

$tpl->show();

?>

