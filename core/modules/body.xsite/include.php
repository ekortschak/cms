<?php

$pge = ENV::getPage();

$txt = APP::gc($pge);
$arr = APP::files("lookup");

if ($arr) {
	incCls("search/lookup.php");

	foreach ($arr as $fil => $nam) {
		$lup = new lookup();
		$lup->addRef($fil, $txt);
	}
	$txt = $lup->insert($txt);
}

if (! $txt) $txt = NV;
echo $txt;

?>
