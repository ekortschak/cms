<?php

incCls("menus/dropBox.php");
incCls("input/selector.php");
incCls("files/pageInfo.php");

HTW::xtag("links.check");

// ***********************************************************
// get parameters
// ***********************************************************
$lng = CUR_LANG;

$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->ronly("dir", PGE::$dir);
$ptn = $sel->ronly("files", "$lng.htm");
$act = $sel->show();

HTM::lf();

// ***********************************************************
// preview
// ***********************************************************
$pge = new pageInfo();
$arr = FSO::fTree($dir, $ptn);
$out = array();
$cnt = 0;

// ***********************************************************
// find broken links
// ***********************************************************
foreach ($arr as $ful => $nam) {
	$txt = file_get_contents($ful); if (STR::misses($txt, "href")) continue;
	$lst = STR::find($txt, "href", ">");

	$dir = dirname($ful);
	$xxx = $pge->read($ful);
	$lnk = $pge->getLink($dir, "pedit");

	$out[$lnk] = array();

	foreach ($lst as $itm) {
		$url = STR::between($itm, '"', '"');
		$chk = CHK::isUrl($url); if ($chk) continue;
		$cnt++;

		$out[$lnk][$itm] = $url;
	}
}

if (! $cnt) {
	return MSG::now("No broken links ...");
}

// ***********************************************************
// output results
// ***********************************************************
echo "<h4>Broken links</h4>";
echo "<small>\n";

foreach ($out as $pge => $lst) {
	if (! $lst) continue;

	HTW::href("?pge=$pge?vmode=pedit", $pge, "chk");
	HTM::lf("br");

	echo "<ul>\n";

	foreach ($lst as $itm => $url) {
		echo "&nbsp; &bull; $url<br>\n";
	}
	echo "</ul>\n";
}
echo "</small>\n";

?>

