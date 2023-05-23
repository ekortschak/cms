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
$pge = ENV::getPage();
$inc = PGE::incFile();
$fil = FSO::join(LOC_MOD, "body", $inc);

$htm = new tpl();
$htm->load("modules/page.tpl");
$htm->setX("banner",  APP::gcRec($pge, "banner"));
$htm->setX("help",    APP::gcSys($pge, "help"));
$htm->setX("head",    APP::gcSys($pge, "head"));
$htm->setX("page",    APP::gcMap($fil));
$htm->setX("tail",    APP::gcSys($pge, "tail"));
$htm->setX("trailer", APP::gcRec($pge, "trailer"));

$out = $htm->gc();

// ***********************************************************
// resolve constants
// ***********************************************************
switch (APP_IDX) {
	case "index.php": $out = CFG::insert($out);
}
echo $out;

?>
