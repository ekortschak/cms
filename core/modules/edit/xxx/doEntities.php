<?php

incCls("menus/dropBox.php");
incCls("input/selector.php");

HTW::xtag("conv.entities");

// ***********************************************************
// get parameters
// ***********************************************************
$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->ronly("dir", PGE::$dir);
$act = $sel->show();

// ***********************************************************
// read ini files
// ***********************************************************
$ini = new ini("files/entities.ini");
$arr = $ini->values("html");

$fls = FSO::fTree($dir);
$cnt = 0;

// ***********************************************************
// edit files
// ***********************************************************
foreach ($fls as $ful => $nam) {
	$txt = APP::read($ful); $cnt++;

	foreach ($arr as $ent => $val) {
		if ($ent == "\s") $ent = " ";
		$txt = STR::replace($txt, "&$ent;", $val);
	}
	APP::write($ful, $txt);
}

// ***********************************************************
// done
// ***********************************************************
HTW::tag("Replacements", "h5");
DBG::tview($arr);

HTW::tag("Done: $cnt files", "p");

?>

