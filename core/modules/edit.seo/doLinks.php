<?php

incCls("menus/dropbox.php");
incCls("input/selector.php");
incCls("files/pageInfo.php");

HTM::tag("links.check");

// ***********************************************************
// get parameters
// ***********************************************************
$loc = PFS::getLoc();
$lng = CUR_LANG;

$sel = new selector();
$oid = $sel->register("search.xxx");
$dir = $sel->ronly("dir", $loc);
$ptn = $sel->ronly("files", "$lng.htm");
$act = $sel->show();

echo "<hr>\n";

// ***********************************************************
// preview
// ***********************************************************
$pge = new pageInfo();
$arr = FSO::ftree($dir, $ptn);
$out = array();
$cnt = 0;

// ***********************************************************
// find broken links
// ***********************************************************
foreach ($arr as $ful => $nam) {
	$txt = file_get_contents($ful); if (! STR::contains($txt, "href")) continue;
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
	echo "No broken links ...";
	return;
}

// ***********************************************************
// output results
// ***********************************************************
echo "<h4>Broken links</h4>";
echo "<small>\n";

foreach ($out as $lnk => $lst) {
	if (! $lst) continue;
	echo "<a href='index.php?pge=$lnk?vmode=pedit' target='chk'>$lnk</a><br>\n";
	echo "<ul>\n";

	foreach ($lst as $itm => $url) {
		echo "&nbsp; &bull; $url<br>\n";
	}
	echo "</ul>\n";
}
echo "</small>\n";

?>
