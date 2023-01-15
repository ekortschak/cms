<?php

// ***********************************************************
HTW::xtag("files.kill");
// ***********************************************************
$dpf = ENV::getParm("dpf");
$dpf = APP::relPath($dpf);

if ($dpf) {
	$arr = LNG::get(); $fil = basename($dpf);

	foreach ($arr as $lng) {
		$fil = FSO::join("dictionary", $lng, $fil);
		FSO::kill($dst);
	}
}

// ***********************************************************
// show files
// ***********************************************************
$arr = FSO::files("dictionary");
$cnt = 0;

foreach ($arr as $fil => $nam) {
	$lnk = HTM::button("?dpf=$fil", $nam);
	echo "<div style='margin-bottom: 3px;'>$lnk</div>";
	$cnt++;
}

if ($cnt < 1) {
	echo DIC::get("no.deletable");
	return;
}

?>
