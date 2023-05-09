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

$fil = FSO::join(LOC_MOD, "body", $inc);
$pge = ENV::getPage();

$htm = new tpl();
$htm->load("modules/page.tpl");
$htm->setVar("banner",  APP::gcRec($pge, "banner"));
$htm->setVar("help",    APP::gcSys($pge, "help"));
$htm->setVar("head",    APP::gcSys($pge, "head"));
$htm->setVar("page",    APP::gcMap($fil));
$htm->setVar("tail",    APP::gcSys($pge, "tail"));
$htm->setVar("trailer", APP::gcRec($pge, "trailer"));

$out = $htm->gc();

// ***********************************************************
// resolve constants
// ***********************************************************
switch (APP_IDX) {
	case "index.php": $out = CFG::insert($out);
}
echo $out;

?>
