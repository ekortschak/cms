<?php

if (TAB_TYPE == "sel")
if (TAB_ROOT == TAB_HOME) return;

if (! TAB_ROOT) {
	return MSG::add("no.tabroot");
}

DBG::file(__FILE__);

// ***********************************************************
// check access permissions
// ***********************************************************
$prm = PFS::hasXs(); // force login ?
if (! $prm) return incMod("body/login.php");

// ***********************************************************
// retrieving main page
// ***********************************************************
$loc = PGE::dir();
$inc = PGE::incFile();
$inc = FSO::join(LOC_MOD, "body/suits", $inc);

$htm = new tpl();
$htm->load("pages/main.tpl");
$htm->setX("banner",  APP::gcRec($loc, "banner"));
$htm->setX("help",    APP::gcSys($loc, "help"));
$htm->setX("head",    APP::gcSys($loc, "head"));
$htm->setX("page",    APP::gcMap($inc));
$htm->setX("tail",    APP::gcSys($loc, "tail"));
$htm->setX("trailer", APP::gcRec($loc, "trailer"));

// ***********************************************************
// show result
// ***********************************************************
$htm->show();

?>
