<?php

if (TAB_TYPE == "select")
if (TAB_ROOT == TAB_PATH) return;

if (! TAB_ROOT) {
	return MSG::add("no.tabroot");
}

// ***********************************************************
// check access permissions
// ***********************************************************
$loc = PFS::getLoc();
$prm = PFS::hasXs(); // force login ?

if (! $prm) return incMod("body/login.php");

// ***********************************************************
// retrieving page info
// ***********************************************************
$ini = new ini();
$tit = $ini->getHead();
$inc = $ini->getIncFile();

// ***********************************************************
// build and show page
// ***********************************************************
HTW::tag($tit, "h3");

$fil = FSO::join("core/modules/body", $inc);

$frm = new tpl();
$frm->load("modules/page.tpl");
$frm->setVar("banner",  APP::gcRec($loc, "banner"));
$frm->setVar("help",    APP::gc($loc, "help"));
$frm->setVar("head",    APP::gc($loc, "head"));
$frm->setVar("page",    APP::gcMap($fil));
$frm->setVar("tail",    APP::gc($loc, "tail"));
$frm->setVar("trailer", APP::gcRec($loc, "trailer"));
$frm->show();

?>
