<?php

// ***********************************************************
HTW::xtag("files.kill");
// ***********************************************************
$dpf = ENV::getParm("dpf");
$dpf = APP::relPath($dpf);

if ($dpf) {
	$dst = FSO::join(APP_DIR, $dpf);
	FSO::kill($dst);
}

$app = FSO::files(APP_DIR."*");
$cnt = 0;

foreach ($app as $fil => $nam) {
	if (STR::contains($nam, "index.php"))  continue;
	if (STR::contains($nam, "x.css.php"))  continue;

	$lnk = HTM::button("?dpf=$fil'>", $nam);
	echo "<div style='margin-bottom: 3px;'>$lnk</div>";
	$cnt++;
}

if ($cnt < 1) {
	echo DIC::get("no.deletable");
	return;
}

?>
