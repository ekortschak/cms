<?php

if (TAB_TYPE == "sel")
if (TAB_ROOT == TAB_PATH) return;

if (! TAB_ROOT) {
	return MSG::add("no.tabroot");
}

// ***********************************************************
// check access permissions
// ***********************************************************
$prm = PFS::hasXs(); // force login ?
if (! $prm) return incMod("body/login.php");

// ***********************************************************
// retrieving page info
// ***********************************************************
$inc = PGE::getIncFile();
$fil = FSO::join("core/modules/body", $inc);

$frm = new tpl();
$frm->load("modules/page.tpl");
$frm->setVar("banner",  APP::gcRec(CUR_PAGE, "banner"));
$frm->setVar("help",    APP::gcMod(CUR_PAGE, "help"));
$frm->setVar("head",    APP::gcMod(CUR_PAGE, "head"));
$frm->setVar("page",    APP::gcMap($fil));
$frm->setVar("tail",    APP::gcMod(CUR_PAGE, "tail"));
$frm->setVar("trailer", APP::gcRec(CUR_PAGE, "trailer"));
$frm->show();

?>
