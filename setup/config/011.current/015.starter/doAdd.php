<?php

HTM::tag("files.copy");

$cpy = ENV::getParm("cpy");
$cpy = APP::relPath($cpy);

if ($cpy) {
	$src = FSO::join(APP_FBK, $cpy);
	$dst = FSO::join(APP_DIR, $cpy);
	FSO::copy($src, $dst);
}

$fbk = FSO::files(APP_FBK."*");
$app = FSO::files(APP_DIR."*");
$div = array_diff($fbk, $app);
$cnt = 0;

foreach ($div as $fil => $nam) {
	if (STR::contains($nam, "debug"))  continue;
	if (STR::contains($nam, "readme")) continue;

	echo "<div style='margin-bottom: 3px;'><a href='?cpy=$fil'><button>$nam</button></a></div>";
	$cnt++;
}

if ($cnt < 1) {
	echo DIC::get("no.missing");
	return;
}

?>
