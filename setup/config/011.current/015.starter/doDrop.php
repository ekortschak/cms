<?php

HTM::tag("files.kill");

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

	echo "<div style='margin-bottom: 3px;'><a href='?dpf=$fil'><button>$nam</button></a></div>";
	$cnt++;
}

if ($cnt < 1) {
	echo DIC::get("no.deletable");
	return;
}

?>
