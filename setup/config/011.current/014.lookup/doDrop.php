<?php

HTM::tag("files.kill");

$dpf = ENV::getParm("dpf");
$dpf = APP::relPath($dpf);

if ($dpf) {
	$dst = FSO::join(APP_DIR, $dpf);
	FSO::kill($dst);
}

// ***********************************************************
// show files
// ***********************************************************
$arr = FSO::files("lookup/*");
$cnt = 0;

foreach ($arr as $fil => $nam) {
	echo "<div style='margin-bottom: 3px;'><a href='?dpf=$fil'><button>$nam</button></a></div>";
	$cnt++;
}

if ($cnt < 1) {
	echo DIC::get("no.deletable");
	return;
}

?>
