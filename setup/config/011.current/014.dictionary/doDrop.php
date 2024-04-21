<?php

// ***********************************************************
HTW::xtag("files.kill");
// ***********************************************************
$fil = ENV::getParm("dpf");
$fil = APP::file($fil);

if ($fil) {
	FSO::kill($fil);
}

// ***********************************************************
// show files
// ***********************************************************
$arr = FSO::files("lookup");
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
