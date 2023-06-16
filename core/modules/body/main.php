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
$loc = ENV::getPage();
$inc = PGE::incFile();
$fil = FSO::join(LOC_MOD, "body", $inc);

$htm = new tpl();
$htm->load("modules/page.tpl");
$htm->setX("banner",  APP::gcRec($loc, "banner"));
$htm->setX("help",    APP::gcSys($loc, "help"));
$htm->setX("head",    APP::gcSys($loc, "head"));
$htm->setX("page",    APP::gcMap($fil));
$htm->setX("tail",    APP::gcSys($loc, "tail"));
$htm->setX("trailer", APP::gcRec($loc, "trailer"));

$out = $htm->gc();

// ***********************************************************
// resolve constants
// ***********************************************************
switch (APP_IDX) {
	case "index.php": $out = CFG::apply($out);
}
echo $out;

?>
