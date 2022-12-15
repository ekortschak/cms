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
HTM::cap($tit, "h3");

$fil = FSO::join("core/modules/body", $inc);
$ful = APP::file($fil);

$frm = new tpl();
$frm->read("design/templates/modules/page.tpl");
$frm->setVar("banner",  APP::gcRec($loc, "banner", false));
$frm->setVar("help",    APP::gc($loc, "help"));
$frm->setVar("head",    APP::gc($loc, "head"));
$frm->setVar("page",    APP::gcBody($ful));
$frm->setVar("tail",    APP::gc($loc, "tail"));
$frm->setVar("trailer", APP::gcRec($loc, "trailer", true));
$frm->show();

// ***********************************************************
// write general trailer
// ***********************************************************
$fil = APP::find($loc, "trailer");
echo APP::gc($fil);

LOG::lapse("body done");

?>
