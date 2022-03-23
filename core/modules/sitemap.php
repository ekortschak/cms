<?php

$mds = ENV::get("vmode"); if (STR::begins($mds, "x")) return;

$dir = PFS::getLoc();
$arr = FSO::folders($dir);
$out = "";

// ***********************************************************
// show default sitemap message
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/msgs/sitemap.tpl");

if (! $arr) {
	$fil = APP::find($dir);
	$sec = ($fil) ? "empty" : "notyet";
	return $tpl->show($sec);
}

// ***********************************************************
// offer subdirectories for further navigation
// ***********************************************************
$out = array();
$anz = CHK::min(count($arr), 30);
$cls = 2; if ($anz > 30) $cls = 3;
$col = 1; $idx = 0;
$max = intval($anz / $cls); if ($max < 2) $max = 2;

foreach ($arr as $dir => $nam) {
	$ini = new ini($dir);
	$tpl->set("link", $ini->getUID());
	$tpl->set("text", $ini->getHead());

	if ($idx++ > $max) {
		$idx = 1; $col++;
	}
	$out = VEC::append($out, $col, $tpl->getSection("item"));
}

// ***********************************************************
// split output into columns
// ***********************************************************
$tpl->set("title", PFS::getTitle());
$cnt = 1;

foreach ($out as $col) {
	$tpl->set("items".$cnt++, $col);
}
$tpl->show("list")

?>
